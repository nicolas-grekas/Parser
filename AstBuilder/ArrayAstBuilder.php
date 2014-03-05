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
class ArrayAstBuilder extends AbstractAstBuilder
{
    public function createToken($type, $token, $line, $semantic)
    {
        return array(
            'type' => $type,
            'text' => $token[1],
            'line' => $line,
            'semantic' => $semantic,
        );
    }

    public function createNode($type)
    {
        return array(
            'type' => $type,
            'kids' => array(),
        );
    }

    public function appendChild(&$node, $child)
    {
        $node['kids'][] = $child;
    }
}
