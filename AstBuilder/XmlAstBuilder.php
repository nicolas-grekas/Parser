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

    public function createToken($type, $token, $line, $semantic)
    {
        $node = $this->doc->createElement($semantic ? 'semantic-token' : 'asemantic-token');
        $node->setAttribute('type', $type);
        $node->setAttribute('line', $line != $token[2] ? $line.'-'.$token[2] : $line);
        $node->appendChild($this->doc->createTextNode($token[1]));

        return $node;
    }

    public function createNode($type)
    {
        return $this->doc->createElement($type);
    }

    public function appendChild(&$node, $child)
    {
        $node->appendChild($child);
    }
}
