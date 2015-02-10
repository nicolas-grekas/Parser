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

        $nodeProto = array(
            'id' => 0,
            'name' => '',
            'asems' => null,
            'ast' => null,
            'startLine' => 1,
            'endLine' => 1,
            'startCol' => 1,
            'endCol' => 1,
            'startByte' => 0,
            'endByte' => 0,
            'startPos' => 0,
            'endPos' => 0,
        );

        $ast = $this->ast;
        $tokenIds = $this->tokenIds;
        $tokenNames = $this->tokenNames;
        $state = 0;
        $stackPos = 0;
        $errFlag = 0;
        $errTok = null;
        $stateStack = array($state);
        $nodeStack = array($nodeProto);
        $asems = $array;
        $tokens = $this->lexer->getTokens($code);

        try {
            foreach ($tokens as $pos => $token) {
                if (isset($tokenNames[$token[0]])) {
                    $tokenName = $tokenNames[$token[0]];
                    $tokenId = $tokenIds[$token[0]];

                    if ($YYBADCH === $tokenId && null === $errTok) {
                        $asems[] = self::createToken($ast, $nodeProto, 0, $tokenName, $token, null, $pos, $pos);

                        continue;
                    }
                } else {
                    $tokenName = "'{$token[1]}'";
                    $tokenId = $YYBADCH;
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
                            if (0 < $errFlag && 2 === --$errFlag) {
                                /* reduce error */

                                $nodeStack[$stackPos] = self::createToken($ast, $nodeProto, $YYINTERRTOK - $YYBADCH, 'error', $errTok, $asems, $errTok[6], $errTok[7]);
                                $asems = $array;

                                foreach ($errTok[5] as $errTok) {
                                    $asems[] = self::createToken($ast, $nodeProto, 0, $errTok[5], $errTok, null, $errTok[6], $errTok[6]);
                                }

                                $errTok = null;
                            }

                            /* shift */

                            ++$stackPos;

                            $nodeStack[$stackPos] = self::createToken($ast, $nodeProto, $tokenId - $YYBADCH, $tokenName, $token, $asems, $pos, $pos);
                            $stateStack[$stackPos] = $state = $yyn;
                            $asems = $array;

                            $tokenId = -1;

                            if (0 > $yyn -= $YYNLSTATES) {
                                /* do not reduce */

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
                                    throw $this->getSyntaxError($tokenName, $state, $token[2], $token[3]);
                                }

                                if ($YYBADCH === $tokenId && isset($tokenNames[$token[0]])) {
                                    $token[5] = $tokenName;
                                    $token[6] = $pos;
                                    $errTok[5][] = $token;
                                } else {
                                    $errTok[5][] = $token;
                                    foreach ($errTok[5] as $token) {
                                        $errTok[1] .= $token[1];
                                    }
                                    $errTok[5] = $array;
                                    $errTok[7] = $pos;
                                }

                                $tokenId = -1;
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
                                        throw $this->getSyntaxError($tokenName, $state, $token[2], $token[3]);
                                    }
                                    $state = $stateStack[--$stackPos];
                                }
                                $stateStack[++$stackPos] = $state = $yyn = $yyaction[$yyn];

                                $errTok = array(-1, '', $token[2], $token[3], $token[4], $array, $pos, $pos);
                            }
                        } elseif ($yyn) {
                            /* reduce */

                            if (isset($yyerror[$yyn])) {
                                throw new Error($yyerror[$yyn], $token[2], $token[3]);
                            }

                            $yyl = $yylen[$yyn] - 1;
                            $yyn = $yylhs[$yyn];
                            $stackPos -= $yyl;

                            if (0 > $yyl || $yyn !== $nodeStack[$stackPos]['id']) {
                                $node = $nodeProto;
                                $node['id'] = $yyn;
                                $node['name'] = $yynode[$yyn];
                                if (0 > $yyl) {
                                    $node['asems'] = $array;
                                } else {
                                    $node['asems'] = $nodeStack[$stackPos]['asems'];
                                    $node['startLine'] = $nodeStack[$stackPos]['startLine'];
                                    $node['startCol'] = $nodeStack[$stackPos]['startCol'];
                                    $node['startByte'] = $nodeStack[$stackPos]['startByte'];
                                    $node['startPos'] = $nodeStack[$stackPos]['startPos'];
                                }
                                $yyp = 1;
                            } else {
                                $node = $nodeStack[$stackPos];
                                $node['asems'] or $node['asems'] = $nodeStack[$stackPos + 1]['asems'];
                                $node['endLine'] = $nodeProto['endLine'];
                                $node['endCol'] = $nodeProto['endCol'];
                                $node['endByte'] = $nodeProto['endByte'];
                                $node['endPos'] = $nodeProto['endPos'];
                                $yyp = 0;
                            }

                            $nodeStack[$stackPos] = $ast->reduceNode($node, array_slice($nodeStack, 1 + $stackPos - $yyp, $yyl + $yyp));

                            /* Goto - shift nonterminal */

                            $yyp = $yygbase[$yyn] + $stateStack[$stackPos - 1];
                            $state = isset($yygcheck[$yyp]) && $yygcheck[$yyp] === $yyn
                                ? $yygoto[$yyp]
                                : $yygdefault[$yyn];

                            $stateStack[$stackPos] = $state;
                        } else {
                            /* accept */

                            $node = $ast->getAst($nodeStack[$stackPos]);
                            $ast->clear();

                            return $node;
                        }

                        if ($state >= $YYNLSTATES) {
                            /* shift-and-reduce */

                            $yyn = $state - $YYNLSTATES;
                        } elseif (-1 === $tokenId) {
                            continue 3;
                        } else {
                            break;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $ast->clear();

            throw $e;
        }
    }

    private static function createToken($ast, &$nodeProto, $tokenId, $tokenName, $token, $asems, $startPos, $endPos)
    {
        $node = $nodeProto;
        $node['id'] = $tokenId;
        $node['name'] = $tokenName;
        $node['asems'] = $asems;
        $node['startPos'] = $startPos;
        $node['endPos'] = $endPos;

        if ($token[2]) {
            $node['endLine'] = $nodeProto['startLine'] += $token[2];
            $node['endCol'] = $nodeProto['startCol'] = 1;
        }
        $node['endCol']  = ($nodeProto['startCol'] += $token[3]) - 1;
        $node['endByte'] = ($nodeProto['startByte'] += $token[4]) - 1;
        $nodeProto['endLine'] = $nodeProto['startLine'];
        $nodeProto['endCol'] = $nodeProto['startCol'];
        $nodeProto['endByte'] = $nodeProto['startByte'] - 1;

        $node['ast'] = $ast->createToken($node, $token[1], $token[0]);

        return $node;
    }

    private function getSyntaxError($tokenName, $state, $line, $col)
    {
        $expected = array();

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

        return new Error($message, $line, $col);
    }
}
