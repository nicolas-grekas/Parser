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
    protected $lexer;
    protected $ast;

    /**
     * Creates a parser instance.
     */
    public function __construct(LexerInterface $lexer, AstBuilderInterface $ast)
    {
        $this->lexer = $lexer;
        $this->ast = $ast;
    }

    /**
     * Parses code.
     *
     * @param string $code The source code to parse
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
        $yytoken = static::$yytoken;
        $yynode = static::$yynode;
        $yymap = static::$yymap;
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

        list($yymap, $yytoken) = $this->lexer->getMaps($yymap, $yytoken, $YYBADCH);

        $ast = $this->ast;
        $state = 0;
        $stackPos = 0;
        $stateStack = array($state);
        $nodeStack = $array;
        $asemantics = $array;
        $line = 1;

        foreach ($this->lexer->getTokens($code) as $token) {
            $tokenName = $yytoken[$token[0]];

            if ($YYBADCH == $tokenId = $yymap[$token[0]]) {
                $asemantics[] = $ast->createToken($tokenName, $token, $line, false);
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

                        $node[0] = $tokenId - $YYBADCH; // Negative id for tokens, positive for nodes
                        $node[1] = $ast->createToken($tokenName, $token, $line, true);
                        $node[2] = $asemantics;
                        $nodeStack[$stackPos] = $node;
                        $stateStack[$stackPos] = $state = $yyn;

                        $tokenId = -1;
                        $asemantics = $array;

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

                                    $expected[] = static::$yytoken[$i]; // Use the parser map, not the lexer one
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

                        if (0 > $yyl || $yyn != $nodeStack[$stackPos][0]) {
                            $node[0] = $yyn;
                            $node[1] = $ast->createNode($yynode[$yyn]);
                            if (0 > $yyl) {
                                $node[2] = $array;
                            } else {
                                $node[2] = $nodeStack[$stackPos][2];
                            }
                            $ast->reduceNode($node, $nodeStack, $stackPos, $yyl, 0);
                            $nodeStack[$stackPos] = $node;
                        } else {
                            $nodeStack[$stackPos][2] or $nodeStack[$stackPos][2] = $nodeStack[$stackPos+1][2];
                            $ast->reduceNode($nodeStack[$stackPos], $nodeStack, $stackPos, $yyl, 1);
                        }

                        /* Goto - shift nonterminal */

                        $yyp = $yygbase[$yyn] + $stateStack[$stackPos-1];
                        $state = isset($yygcheck[$yyp]) && $yygcheck[$yyp] == $yyn
                            ? $yygoto[$yyp]
                            : $yygdefault[$yyn];

                        $stateStack[$stackPos] = $state;
                    } else {
                        /* accept */

                        $node =& $nodeStack[$stackPos];
                        $node[0] = 0;
                        $node[2] = $asemantics;
                        $ast->reduceNode($node, $nodeStack, $stackPos, 0, 0);

                        return $node[1];
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
