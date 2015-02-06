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
class XmlAstBuilder extends AbstractAstBuilder
{
    protected $doc;

    /**
     * {@inheritdoc}
     */
    public function createToken($name, $token, $semantic, $pos)
    {
        $node = $this->doc->createElement($semantic ? 'semantic-token' : 'asemantic-token');
        $node->setAttribute('name', $name);
        $node->setAttribute('line', $token[2]);
        $node->appendChild($this->doc->createTextNode($token[1]));

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    protected function createNode($name, $ruleId)
    {
        return $this->doc->createElement($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function appendChild(&$ast, $child)
    {
        $ast->appendChild($child);
    }

    /**
     * {@inheritdoc}
     */
    public function getAst($ast)
    {
        $this->doc->appendChild($ast);

        return $this->doc;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->doc = new \DOMDocument();
    }
}
