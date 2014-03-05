<?php

namespace Tchwork\Parser;

use DOMDocument;

require 'vendor/autoload.php';

$lexer = new Lexer\PhpLexer();

$doc = new DOMDocument();
$ast = new AstBuilder\XmlAstBuilder($doc);
$parser = new Parser\PhpParser($lexer, $ast);

$ast = $parser->parse(file_get_contents(isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : __FILE__));
$doc->appendChild($ast);

$doc->preserveWhiteSpace = true;
$doc->formatOutput = true;

echo $doc->saveXML();
