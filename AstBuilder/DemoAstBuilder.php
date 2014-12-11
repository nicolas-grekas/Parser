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
class DemoAstBuilder implements AstBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function createToken($name, $id, $code, $startLine, $endLine, $semantic)
    {
        return $code;
    }

    /**
     * {@inheritdoc}
     */
    public function createNode($name, $ruleId)
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function reduceNode(array $node, array $children)
    {
        if (self::ERROR === $node['name']) {
            $node['ast'] = 'Syntax error, unexpected: ';
            foreach ($children as $c) {
                $node['ast'] .= implode('', $c['asems']).$c['ast'];
            }

            return $node;
        }
        if ('expr' === $node['name'] && isset($children[1])) {
            switch ($children[1]['ast']) {
                case '+': $children[0]['ast'] += $children[2]['ast']; break;
                case '-': $children[0]['ast'] -= $children[2]['ast']; break;
                case '*': $children[0]['ast'] *= $children[2]['ast']; break;
                case '/': $children[0]['ast'] /= $children[2]['ast']; break;
                default: return $children[1];
            }
        } elseif ('line' === $node['name']) {
            if ("\n" !== $children[0]['ast']) {
                echo '=> ', $children[0]['ast'], "\n\n";
            }
        }

        if ($children) {
            return $children[0];
        }

        return $node;
    }
}
