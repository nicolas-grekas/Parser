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
    public function createToken($name, $id, $code, $startLine, $endLine, $semantic)
    {
        return array(
            'name' => $name,
            'code' => $code,
            'line' => $startLine,
            'semantic' => $semantic,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createNode($name, $ruleId)
    {
        return array(
            'name' => $name,
            'kids' => array(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function appendChild(&$ast, $child)
    {
        $ast['kids'][] = $child;
    }
}
