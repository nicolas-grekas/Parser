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
    /**
     * {@inheritdoc}
     */
    public function createToken(&$node, $code, $type)
    {
        return array(
            'name' => $node['name'],
            'code' => $code,
            'line' => $node['startLine'],
            'semantic' => null !== $node['asems'],
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function createNode(&$node)
    {
        return array(
            'name' => $node['name'],
            'kids' => array(),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function appendChild(&$node, $child)
    {
        if (isset($child['asems'])) {
            $node['ast']['kids'][] = $child['ast'];
        }
    }
}
