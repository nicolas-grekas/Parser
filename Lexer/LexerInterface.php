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
     * Each token is a numerically indexed array of 3 items:
     * - the token id: either a T_* constant or a single character
     * - the source code excerpt
     * - the ending line of the token
     *
     * @return array|Traversable The lexer's tokens for $code
     */
    public function getTokens($code);
}
