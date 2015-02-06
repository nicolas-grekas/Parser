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
    public function createToken($name, $token, $semantic, $pos)
    {
        return array(
            'name' => $name,
            'code' => $token[1],
            'line' => $token[2],
            'semantic' => $semantic,
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function createNode($name, $ruleId)
    {
        return array(
            'name' => $name,
            'kids' => array(),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function appendChild(&$ast, $child)
    {
        $ast['kids'][] = $child;
    }
}
