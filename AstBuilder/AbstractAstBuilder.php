<?php

/*
 * (c) Nicolas Grekas <p@tchwork.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchwork\Parser\AstBuilder;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractAstBuilder implements AstBuilderInterface
{
    abstract public function createToken($type, $token, $line, $semantic);
    abstract public function createNode($type);
    abstract public function appendChild(&$node, $child);

    public function reduceNode(&$node, $nodeStack, $stackPos, $yyl, $stackOffset)
    {
        for ($i = $stackOffset; $i <= $yyl; ++$i) {
            $n = $nodeStack[$stackPos + $i];
            foreach ($n[2] as $asemantic) {
                if ($asemantic) {
                    $this->appendChild($node[1], $asemantic);
                }
            }
            if ($n[0] && $n[1]) {
                $this->appendChild($node[1], $n[1]);
            }
        }
    }
}
