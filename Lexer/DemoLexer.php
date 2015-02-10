<?php

/*
 * (c) Nicolas Grekas <p@tchwork.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchwork\Parser\Lexer;

use Tchwork\Parser\Exception\Error;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DemoLexer implements LexerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getMaps(array $yymap, array $yytoken, $yyasemid)
    {
        $map = array();
        $token = array();

        foreach ($yytoken as $yyid => $yyname) {
            $id = $yymap[$yyid];

            if ($yymap[$yyid] <= 255) {
                $id = chr($id);
            }

            $token[$id] = $yyname;
            $map[$id] = $yyid;
        }

        $token[' '] = 'SPACE';
        $map[' '] = $yyasemid;

        return array($map, $token);
    }

    /**
     * {@inheritdoc}
     */
    public function getTokens($code)
    {
        while (false !== $line = fgets($code)) {
            while (isset($line[0])) {
                if (preg_match('/^\d+/', $line, $match)) {
                    $len = strlen($match[0]);
                    yield [257, $match[0], 0, $len, $len];
                    $line = substr($line, $len);
                } else {
                    $lf = (int) ("\n" === $line[0]);
                    yield [$line[0], $line[0], $lf, 1 - $lf, 1];

                    $line = substr($line, 1);
                }
            }
        }

        yield [0, '', 1];
    }
}
