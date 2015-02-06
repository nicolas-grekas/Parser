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
     * @param mixed &$ast  The parent AST node, as returned by ->createNode()
     * @param mixed $child The child AST node, as returned by ->createNode() or ->createToken()
     *
     * @return void
     */
    abstract protected function appendChild(&$ast, $child);

    /**
     * {@inheritdoc}
     */
    abstract public function createToken($name, $token, $semantic, $pos);

    /**
     * Creates an AST node representation.
     *
     * @param string $name   The name of the node's grammar rule
     * @param int    $ruleId The identifier of the node's grammar rule
     *
     * @return mixed The node representation
     */
    abstract protected function createNode($name, $ruleId);

    /**
     * {@inheritdoc}
     */
    public function reduceNode(array $node, array $children)
    {
        isset($node['ast']) or $node['ast'] = $this->createNode($node['name'], $node['id']);

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

    /**
     * {@inheritdoc}
     */
    public function getAst($ast)
    {
        return $ast;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
    }
}
