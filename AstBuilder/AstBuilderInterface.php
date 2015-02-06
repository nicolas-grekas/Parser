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
    const ERROR = 'error';

    /**
     * Creates an AST token representation.
     *
     * @param string $name     The symbolic name of the token
     * @param array  $token    The token as returned by the lexer
     * @param bool   $semantic True/false when the token is semantic/asemantic
     * @param int    $pos      Position in the token stream generated by the lexer
     *
     * @return mixed The token representation
     */
    public function createToken($name, $token, $semantic, $pos);

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

    /**
     * Closes and returns the AST.
     *
     * @param mixed The not-closed but reduced AST.
     *
     * @return mixed The closed AST representation.
     */
    public function getAst($ast);

    /**
     * Clears any state and gets ready to build a new AST.
     *
     * @return void
     */
    public function clear();
}
