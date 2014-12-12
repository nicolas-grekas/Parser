<?php

/*
 * (c) Nicolas Grekas <p@tchwork.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchwork\Parser\AstBuilder;

use DOMDocument;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class XmlAstBuilder extends AbstractAstBuilder
{
    protected $doc;

    public function __construct(DOMDocument $doc)
    {
        $this->doc = $doc;
    }

    /**
     * {@inheritdoc}
     */
    public function createToken($name, $id, $code, $startLine, $endLine, $semantic)
    {
        $node = $this->doc->createElement($semantic ? 'semantic-token' : 'asemantic-token');
        $node->setAttribute('name', $name);
        $node->setAttribute('line', $startLine !== $endLine ? $startLine.'-'.$endLine : $startLine);
        $node->appendChild($this->doc->createTextNode($code));

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    public function createNode($name, $ruleId)
    {
        return $this->doc->createElement($name);
    }

    /**
     * {@inheritdoc}
     */
    public function appendChild(&$ast, $child)
    {
        $ast->appendChild($child);
    }
}
