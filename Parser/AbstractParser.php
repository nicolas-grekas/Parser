<?php

/*
 * (c) Nicolas Grekas <p@tchwork.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchwork\Parser\Parser;

use Tchwork\Parser\AstBuilder\AstBuilderInterface;
use Tchwork\Parser\Exception\Error;
use Tchwork\Parser\Lexer\LexerInterface;

/**
 * The skeleton for this parser was written by Moriyoshi Koizumi
 * and is based on the work by Masato Bito.
 *
 * @author Moriyoshi Koizumi
 * @author Masato Bito
 * @author Nikita Popov
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractParser
{
    private $lexer;                  // The LexerInterface object used to provide tokens
    private $ast;                    // The AstBuilderInterface object used to build the parsing result
    private $tokenIds = array();     // Map lexer tokens to parser ids
    private $tokenNames = array();   // Map lexer tokens from their id to their name

    protected $YY2TBLSTATE = 0;
    protected $YYNLSTATES = 0;
    protected $YYUNEXPECTED = 0;     // Id of the "unexpected token" rule
    protected $YYDEFAULT = 0;        // Id for default action
    protected $YYBADCH = 0;          // Id of asemantic tokens
    protected $YYINTERRTOK = 0;      // Id of the special "error" token

    protected $yyerror = array();    // Map rules to parse error messages
    protected $yytoken = array();    // Map token ids to their name
    protected $yynode = array();     // Map node ids to their name
    protected $yymap = array();      // Map lexer tokens to parser ids
    protected $yyaction = array();   // Map of actions indexed by $yybase[$state] + $tokenId
    protected $yycheck = array();
    protected $yybase = array();
    protected $yydefault = array();  // Map of states to their default action
    protected $yygoto = array();     // Map of states to goto after reduction indexed by $yygbase[$nodeId] + $state
    protected $yygcheck = array();
    protected $yygbase = array();
    protected $yygdefault = array(); // Map nodes to the default state to goto after reduction
    protected $yylhs = array();      // Map rules to their parent node, determining the state to goto after reduction
    protected $yylen = array();      // Map rules to their number of child nodes

    /**
     * Creates a parser instance.
     */
    public function __construct(LexerInterface $lexer, AstBuilderInterface $ast)
    {
        $this->lexer = $lexer;
        $this->ast = $ast;

        list($this->tokenIds, $this->tokenNames) = $this->lexer->getMaps(array_flip($this->yymap), $this->yytoken, $this->YYBADCH);

        $this->tokenNames[0] = 'EOF';
        $this->tokenIds[0] = 0;
    }

    /**
     * Parses code.
     *
     * @param mixed $code The source code to parse
     *
     * @return array AST
     */
    public function parse($code)
    {
        // Alias locally for speed
        $YY2TBLSTATE = $this->YY2TBLSTATE;
        $YYNLSTATES = $this->YYNLSTATES;
        $YYUNEXPECTED = $this->YYUNEXPECTED;
        $YYDEFAULT = $this->YYDEFAULT;
        $YYBADCH = $this->YYBADCH;
        $YYINTERRTOK = $this->YYINTERRTOK;

        $yyerror = $this->yyerror;
        $yynode = $this->yynode;
        $yyaction = $this->yyaction;
        $yycheck = $this->yycheck;
        $yybase = $this->yybase;
        $yydefault = $this->yydefault;
        $yygoto = $this->yygoto;
        $yygcheck = $this->yygcheck;
        $yygbase = $this->yygbase;
        $yygdefault = $this->yygdefault;
        $yylhs = $this->yylhs;
        $yylen = $this->yylen;
        $array = array();
        $node = $array;

        $ast = $this->ast;
        $tokenIds = $this->tokenIds;
        $tokenNames = $this->tokenNames;
        $state = 0;
        $stackPos = 0;
        $errFlag = 0;
        $stateStack = array($state);
        $nodeStack = $array;
        $asems = $array;
        $line = 1;

        foreach ($this->lexer->getTokens($code) as $token) {
            if (!isset($tokenNames[$token[0]])) {
                $tokenId = $YYBADCH;
                $tokenName = "'{$token[1]}'";
            } else {
                $tokenName = $tokenNames[$token[0]];

                if ($YYBADCH === $tokenId = $tokenIds[$token[0]]) {
                    $asems[] = $ast->createToken($tokenName, $token[0], $token[1], $line, $token[2], false);
                    $line = $token[2];

                    continue;
                }
            }

            for (;;) {
                if ($yybase[$state]
                    && (isset($yycheck[$yyn = $yybase[$state] + $tokenId])
                        && $yycheck[$yyn] === $tokenId
                        || $state < $YY2TBLSTATE
                        && isset($yycheck[$yyn = $yybase[$state + $YYNLSTATES] + $tokenId])
                        && $yycheck[$yyn] === $tokenId)
                    && ($yyn = $yyaction[$yyn]) !== $YYDEFAULT
                ) {
                    if ($yyn > 0) {
                        /* shift */

                        ++$stackPos;

                        $node['id'] = $tokenId - $YYBADCH; // Negative id for tokens, positive for nodes
                        $node['name'] = $tokenName;
                        $node['ast'] = $ast->createToken($tokenName, $token[0], $token[1], $line, $token[2], true);
                        $node['asems'] = $asems;
                        $nodeStack[$stackPos] = $node;
                        $stateStack[$stackPos] = $state = $yyn;

                        $tokenId = -1;
                        $asems = $array;

                        if (0 < $errFlag) {
                            --$errFlag;
                        }

                        if (0 > $yyn -= $YYNLSTATES) {
                            /* do not reduce */
                            $line = $token[2];

                            continue 2;
                        }
                    } else {
                        $yyn = -$yyn;
                    }
                } else {
                    $yyn = $yydefault[$state];
                }

                for (;;) {
                    if ($yyn === $YYUNEXPECTED) {
                        /* error */

                        if (3 === $errFlag) {
                            /* discard */

                            if (!$tokenId) {
                                throw $this->getSyntaxError($tokenName, $state, $line);
                            }

                            $node['id'] = -$YYBADCH;
                            $node['name'] = $tokenName;
                            $node['ast'] = $ast->createToken($tokenName, $token[0], $token[1], $line, $token[2], true);
                            $node['asems'] = $asems;
                            $nodeStack[$stackPos] = $ast->reduceNode($nodeStack[$stackPos], array($node));
                            if ('error' !== $nodeStack[$stackPos]['name']) {
                                throw new Error(sprintf('Node `error` has been renamed to `%s` upon reduction by %s', $nodeStack[$stackPos]['name'], get_class($ast)), $line);
                            }

                            $tokenId = -1;
                            $asems = $array;
                        } else {
                            /* recover */

                            $errFlag = 3;

                            while (!(isset($yycheck[$yyn = $yybase[$state] + $YYINTERRTOK])
                                && $yycheck[$yyn] === $YYINTERRTOK
                                || $state < $YY2TBLSTATE
                                && isset($yycheck[$yyn = $yybase[$state + $YYNLSTATES] + $YYINTERRTOK])
                                && $yycheck[$yyn] === $YYINTERRTOK
                            )) {
                                if (0 >= $stackPos) {
                                    throw $this->getSyntaxError($tokenName, $state, $line);
                                }
                                $state = $stateStack[--$stackPos];
                            }
                            $stateStack[++$stackPos] = $state = $yyn = $yyaction[$yyn];

                            $node['id'] = $yyn;
                            $node['ast'] = $ast->createNode($node['name'] = 'error', $yyn);
                            $node['asems'] = $asems;

                            $nodeStack[$stackPos] = $node;
                        }
                    } elseif ($yyn) {
                        /* reduce */

                        if (isset($yyerror[$yyn])) {
                            throw new Error($yyerror[$yyn], $line);
                        }

                        $yyl = $yylen[$yyn] - 1;
                        $yyn = $yylhs[$yyn];
                        $stackPos -= $yyl;

                        if (0 > $yyl || $yyn !== $nodeStack[$stackPos]['id']) {
                            $node['id'] = $yyn;
                            $node['ast'] = $ast->createNode($node['name'] = $yynode[$yyn], $yyn);
                            if (0 > $yyl) {
                                $node['asems'] = $array;
                            } else {
                                $node['asems'] = $nodeStack[$stackPos]['asems'];
                            }
                            $nodeStack[$stackPos] = $ast->reduceNode($node, array_slice($nodeStack, $stackPos - 1, $yyl + 1));
                        } else {
                            $nodeStack[$stackPos]['asems'] or $nodeStack[$stackPos]['asems'] = $nodeStack[$stackPos + 1]['asems'];
                            $nodeStack[$stackPos] = $ast->reduceNode($nodeStack[$stackPos], array_slice($nodeStack, $stackPos, $yyl));
                        }

                        /* Goto - shift nonterminal */

                        $yyp = $yygbase[$yyn] + $stateStack[$stackPos-1];
                        $state = isset($yygcheck[$yyp]) && $yygcheck[$yyp] === $yyn
                            ? $yygoto[$yyp]
                            : $yygdefault[$yyn];

                        $stateStack[$stackPos] = $state;
                    } else {
                        /* accept */

                        $node['id'] = 0;
                        $node['name'] = 'EOF';
                        $node['ast'] = $ast->createToken('EOF', $token[0], $token[1], $line, $token[2], true);
                        $node['asems'] = $asems;
                        $node = $ast->reduceNode($nodeStack[$stackPos], array($node));

                        return $node['ast'];
                    }

                    if ($state >= $YYNLSTATES) {
                        /* shift-and-reduce */

                        $yyn = $state - $YYNLSTATES;
                    } elseif (-1 === $tokenId) {
                        $line = $token[2];

                        continue 3;
                    } else {
                        break;
                    }
                }
            }
        }
    }

    private function getSyntaxError($tokenName, $state, $line)
    {
        $expected = $array;

        for ($i = 1; $i < $this->YYBADCH; ++$i) {
            if (isset($this->yycheck[$yyn = $this->yybase[$state] + $i])
                && $this->yycheck[$yyn] === $i
                || $state < $this->YY2TBLSTATE
                && isset($this->yycheck[$yyn = $this->yybase[$state + $this->YYNLSTATES] + $i])
                && $this->yycheck[$yyn] === $i
            ) {
                if ($this->yyaction[$yyn] !== $this->YYUNEXPECTED) {
                    if (4 === count($expected)) {
                        /* Too many expected tokens */
                        $expected = array();
                        break;
                    }

                    $expected[] = $this->yytoken[$i];
                }
            }
        }

        $message = 'Syntax error, unexpected '.$tokenName;
        if ($expected) {
            $last = array_pop($expected);
            $message .= ', expecting '.($expected ? implode(', ', $expected).' or ' : '').$last;
        }

        return new Error($message, $line);
    }
}
