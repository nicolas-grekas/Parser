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
    public function createToken($type, $token, $line, $semantic);
    public function createNode($type);
    public function reduceNode(&$node, $nodeStack, $stackPos, $yyl, $stackOffset);
}
