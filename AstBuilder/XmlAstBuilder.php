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
    public function createToken(&$node, $code, $type)
    {
        $elt = $this->doc->createElement(isset($node['asems']) ? 'semantic-token' : 'asemantic-token');
        $elt->setAttribute('name', $node['name']);
        $elt->setAttribute('line', $node['startLine']);
        $elt->appendChild($this->doc->createTextNode($code));

        return $elt;
    }

    /**
     * {@inheritdoc}
     */
    protected function createNode(&$node)
    {
        return $this->doc->createElement($node['name']);
    }

    /**
     * {@inheritdoc}
     */
    protected function appendChild(&$node, $child)
    {
        $node['ast']->appendChild($child['ast']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAst($node)
    {
        $this->doc->appendChild($node['ast']);

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
