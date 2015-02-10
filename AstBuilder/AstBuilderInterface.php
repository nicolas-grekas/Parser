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
     * @param array  &$node The context of the token to create (@see reduceNode)
     * @param string $code  The source code excerpt for the token
     * @param mixed  $type  The type identifier of the token as given by the lexer
     *
     * @return mixed The AST representation for the token
     */
    public function createToken(&$node, $code, $type);

    /**
     * Reduces a grammar rule/node.
     *
     * @param array $node     The context of the node to reduce:
     *                        - id: the identifier of the reduced grammar rule
     *                        - name: the name of the grammar rule
     *                        - asems: preceding asemantic token nodes
     *                        - ast: the AST representation of the node or null when this is to be created
     *                        - startLine, endLine, startCol, endCol, startByte, endByte, startPos, endPos
     * @param array $children Array of child nodes, each with the same structure as above
     *
     * @return array The reduced node with its AST representation
     */
    public function reduceNode($node, $children);

    /**
     * Closes and returns the AST.
     *
     * @param array The root node resulting from the parsed grammar.
     *
     * @return mixed The closed AST representation.
     */
    public function getAst($node);

    /**
     * Clears any state and gets ready to build a new AST.
     *
     * @return void
     */
    public function clear();
}
