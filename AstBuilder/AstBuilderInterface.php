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
interface AstBuilderInterface
{
    /**
     * Creates an AST token representation.
     *
     * @param string     $name      The symbolic name of the token
     * @param int|string $id        The lexer id of the token
     * @param string     $code      The source code excerpt
     * @param int        $startLine Start line of the token
     * @param int        $endLine   End line of the token
     * @param bool       $semantic  True/false when the token is semantic/asemantic
     *
     * @return mixed The token representation
     */
    public function createToken($name, $id, $code, $startLine, $endLine, $semantic);

    /**
     * Creates an AST node representation.
     *
     * @param string $name   The name of the node's grammar rule
     * @param int    $ruleId The identifier of the node's grammar rule
     *
     * @return mixed The node representation
     */
    public function createNode($name, $ruleId);

    /**
     * Reduces a grammar rule/node.
     *
     * @param array $node     The node to reduce within 4 keys:
     *                        - ruleId: the identifier of the reduced grammar rule
     *                        - name: the name of the grammar rule
     *                        - ast: the AST node as returned by ->createNode()
     *                        - asems: Preceding asemantic tokens as returned by ->createToken()
     * @param array $children Array of child nodes, each with the same structure as above
     *
     * @return array The reduced node
     */
    public function reduceNode(array $node, array $children);
}
