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
    private $lexer;
    private $ast;
    private $tokenIds;
    private $tokenNames;

    /**
     * Creates a parser instance.
     */
    public function __construct(LexerInterface $lexer, AstBuilderInterface $ast)
    {
        $this->lexer = $lexer;
        $this->ast = $ast;

        list($this->tokenIds, $this->tokenNames) = $this->lexer->getMaps(array_flip(static::$yymap), static::$yytoken, static::YYBADCH);

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
        $YY2TBLSTATE = static::YY2TBLSTATE;
        $YYNLSTATES = static::YYNLSTATES;
        $YYUNEXPECTED = static::YYUNEXPECTED;
        $YYDEFAULT = static::YYDEFAULT;
        $YYBADCH = static::YYBADCH;

        $yyerror = static::$yyerror;
        $yynode = static::$yynode;
        $yyaction = static::$yyaction;
        $yycheck = static::$yycheck;
        $yybase = static::$yybase;
        $yydefault = static::$yydefault;
        $yygoto = static::$yygoto;
        $yygcheck = static::$yygcheck;
        $yygbase = static::$yygbase;
        $yygdefault = static::$yygdefault;
        $yylhs = static::$yylhs;
        $yylen = static::$yylen;
        $array = array();
        $node = $array;

        $ast = $this->ast;
        $tokenIds = $this->tokenIds;
        $tokenNames = $this->tokenNames;
        $state = 0;
        $stackPos = 0;
        $stateStack = array($state);
        $nodeStack = $array;
        $asems = $array;
        $line = 1;

        foreach ($this->lexer->getTokens($code) as $token) {
            $tokenName = $tokenNames[$token[0]];

            if ($YYBADCH == $tokenId = $tokenIds[$token[0]]) {
                $asems[] = $ast->createToken($tokenName, $token[0], $token[1], $line, $token[2], false);
                $line = $token[2];

                continue;
            }

            for (;;) {
                if ($yybase[$state]
                    && (isset($yycheck[$yyn = $yybase[$state] + $tokenId])
                        && $yycheck[$yyn] == $tokenId
                        || $state < $YY2TBLSTATE
                        && isset($yycheck[$yyn = $yybase[$state + $YYNLSTATES] + $tokenId])
                        && $yycheck[$yyn] == $tokenId)
                    && ($yyn = $yyaction[$yyn]) != $YYDEFAULT
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
                    if ($yyn == $YYUNEXPECTED) {
                        /* error */

                        $expected = $array;

                        $base = $yybase[$state];
                        for ($i = 1; $i < $YYBADCH; ++$i) {
                            if (isset($yycheck[$n = $base + $i])
                                && $yycheck[$n] == $i
                                || $state < $YY2TBLSTATE
                                && isset($yycheck[$n = $yybase[$state + $YYNLSTATES] + $i])
                                && $yycheck[$n] == $i
                            ) {
                                if ($yyaction[$n] != $YYUNEXPECTED) {
                                    if (count($expected) == 4) {
                                        /* Too many expected tokens */
                                        $expected = $array;
                                        break;
                                    }

                                    $expected[] = static::$yytoken[$i];
                                }
                            }
                        }

                        $expectedString = $tokenName;
                        if ($expected) {
                            $expectedString .= ', expecting '.implode(' or ', $expected);
                        }

                        throw new Error('Syntax error, unexpected '.$expectedString, $token[2]);
                    } elseif ($yyn) {
                        /* reduce */

                        if (isset($yyerror[$yyn])) {
                            throw new Error($yyerror[$yyn], $token[2]);
                        }

                        $yyl = $yylen[$yyn] - 1;
                        $yyn = $yylhs[$yyn];
                        $stackPos -= $yyl;

                        if (0 > $yyl || $yyn != $nodeStack[$stackPos]['id']) {
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
                        $state = isset($yygcheck[$yyp]) && $yygcheck[$yyp] == $yyn
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
                    } elseif (-1 == $tokenId) {
                        $line = $token[2];

                        continue 3;
                    } else {
                        break;
                    }
                }
            }
        }
    }
}
