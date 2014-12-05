<?php

/*
 * (c) Nicolas Grekas <p@tchwork.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchwork\Parser\Exception;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class SyntaxError extends Error
{
    public function __construct($unexpected, array $expected, $line = -1)
    {
        $message = 'Syntax error, unexpected '.$unexpected;
        if ($expected) {
            $message .= ', expecting '.implode(' or ', $expected);
        }

        parent::__construct($message, $line);
    }
}
