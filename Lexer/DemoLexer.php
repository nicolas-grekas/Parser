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
        $lineNo = 1;
        $colNo = 1;
        $seekNo = 0;

        while (false !== $line = fgets($code)) {
            while (isset($line[0])) {
                if (preg_match('/^\d+/', $line, $match)) {
                    yield [257, $match[0], $lineNo, $colNo, $seekNo];
                    $len = strlen($match[0]);
                    $line = substr($line, $len);
                    $colNo += $len;
                    $seekNo += $len;
                } else {
                    if ("\n" === $line[0]) {
                        ++$lineNo;
                        $colNo = 1;
                    }

                    yield [$line[0], $line[0], $lineNo, $colNo, $seekNo];
                    $line = substr($line, 1);
                    ++$colNo;
                    ++$seekNo;
                }
            }
        }

        yield [0, '', 1];
    }
}
