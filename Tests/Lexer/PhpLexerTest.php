<?php

/*
 * (c) Nicolas Grekas <p@tchwork.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchwork\Parser\Tests;

use Tchwork\Parser\Lexer;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class PhpLexerTest extends \PHPUnit_Framework_TestCase
{
    public function testWithBadCharacters()
    {
        $lexer = new PhpLexer();

        $code = "<?php \x00";
        $x = array(
            array(T_OPEN_TAG, '<?php ', 1, 1, 0),
            array(T_BAD_CHARACTER, "\x00", 1, 7, 6),
            array(0, '', 1, 8, 7),
        );

        $this->assertSame($x, $lexer->getTokens($code));
    }

    public function testRestoreHaltCompilerData()
    {
        $lexer = new PhpLexer();

        $endLine = 1;
        $code = "<?php __halt_compiler();\x00";
        $tokens = array(
            array(T_OPEN_TAG, '<?php ', 1),
            array(T_HALT_COMPILER, '__halt_compiler', 1),
        );
        $x = array_merge($tokens, array('(', ')', ';', array(T_INLINE_HTML, "\x00", 1)));

        $lexer->testRestoreHaltCompilerData($code, $tokens, $endLine);

        $this->assertSame($x, $tokens);
    }

    public function testInlineHaltCompilerData()
    {
        $lexer = new PhpLexer();

        $endLine = 1;
        $code = "<?php __halt_compiler();\x00";
        $tokens = array(
            array(T_OPEN_TAG, '<?php ', 1),
            array(T_HALT_COMPILER, '__halt_compiler', 1),
            '(', ')', ';',
            array(T_BAD_CHARACTER, "\x00", 1),
        );
        $x = $tokens;
        $x[5][0] = T_INLINE_HTML;

        $lexer->testInlineHaltCompilerData($tokens, $endLine);

        $this->assertSame($x, $tokens);
    }
}

class PhpLexer extends Lexer\PhpLexer
{
    public function testRestoreHaltCompilerData($code, &$tokens, &$endLine)
    {
        $this->restoreHaltCompilerData($code, $tokens, $endLine);
    }

    public function testInlineHaltCompilerData(&$tokens, &$endLine)
    {
        $this->inlineHaltCompilerData($tokens, $endLine);
    }
}
