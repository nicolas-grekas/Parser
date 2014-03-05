<?php

/*
 * (c) Nicolas Grekas <p@tchwork.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchwork\Parser\Lexer;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
interface LexerInterface
{
    public function getMaps($yymap, $yytoken, $YYBADCH);
    public function getTokens($code);
}
