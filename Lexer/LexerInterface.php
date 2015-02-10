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
    /**
     * Maps lexer tokens to parser's ones.
     *
     * @param array $yymap    Parser's map of lexer to parser token ids
     * @param array $yytoken  Parser's map of token ids to token names
     * @param int   $yyasemid Parser's token id for asemantic tokens
     *
     * @return array The ids and names token maps from lexer ids to parser space.
     */
    public function getMaps(array $yymap, array $yytoken, $yyasemid);

    /**
     * Splits a string of PHP code into a list of tokens.
     *
     * Each token is a numerically indexed array of 5 items:
     * - type identifier
     * - source code excerpt
     * - number of lines
     * - number of columns on the last line
     * - number of bytes
     *
     * @param mixed $code The source code to lex
     *
     * @return array|Traversable The lexer's tokens for $code
     */
    public function getTokens($code);
}
