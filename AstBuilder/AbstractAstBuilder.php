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
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Appends a child to an AST node.
     *
     * @param array &$node The parent node
     * @param array $child The child node
     *
     * @return void
     */
    abstract protected function appendChild(&$node, $child);

    /**
     * {@inheritdoc}
     */
    abstract public function createToken(&$node, $code, $type);

    /**
     * Creates an AST node representation.
     *
     * @param array &$node The node missing an AST representation
     *
     * @return mixed The AST representation for the node
     */
    abstract protected function createNode(&$node);

    /**
     * {@inheritdoc}
     */
    public function reduceNode($node, $children)
    {
        isset($node['ast']) or $node['ast'] = $this->createNode($node);

        foreach ($children as $n) {
            foreach ($n['asems'] as $a) {
                $this->appendChild($node, $a);
            }
            $this->appendChild($node, $n);
        }

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    public function getAst($node)
    {
        return $node['ast'];
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
    }
}
