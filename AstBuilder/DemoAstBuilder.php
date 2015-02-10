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
    public function createToken(&$node, $code, $type)
    {
        return $code;
    }

    /**
     * {@inheritdoc}
     */
    public function reduceNode($node, $children)
    {
        if (self::ERROR === $node['name']) {
            foreach ($children[0]['asems'] as $a) {
                $node['ast'] .= $a['ast'];
            }
            $node['ast'] .= $children[0]['ast'];

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
                if (self::ERROR === $children[0]['name']) {
                    echo "Syntax error, unexpected `{$children[0]['ast']}`\n\n";
                } else {
                    echo '=> ', $children[0]['ast'], "\n\n";
                }
            }
        }

        if ($children) {
            return $children[0];
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
