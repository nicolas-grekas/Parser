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
    /**
     * Appends a child to an AST node.
     *
     * @param mixed &$ast  The parent AST node, as returned by ->createNode()
     * @param mixed $child The child AST node, as returned by ->createNode() or ->createToken()
     *
     * @return void
     */
    abstract public function appendChild(&$ast, $child);

    /**
     * {@inheritdoc}
     */
    abstract public function createToken($name, $id, $code, $startLine, $endLine, $semantic);

    /**
     * {@inheritdoc}
     */
    abstract public function createNode($name, $ruleId);

    /**
     * {@inheritdoc}
     */
    public function reduceNode(array $node, array $children)
    {
        foreach ($children as $n) {
            foreach ($n['asems'] as $a) {
                $this->appendChild($node['ast'], $a);
            }
            if ($n['id']) {
                $this->appendChild($node['ast'], $n['ast']);
            }
        }

        return $node;
    }
}
