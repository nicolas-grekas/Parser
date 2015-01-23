<?php

namespace Tchwork\Parser;

use DOMDocument;

require __DIR__.'/../vendor/autoload.php';

$lexer = new Lexer\PhpLexer();

$ast = new AstBuilder\XmlAstBuilder();
$parser = new Parser\PhpParser($lexer, $ast);

$doc = $parser->parse(file_get_contents(isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : __FILE__));
$doc->preserveWhiteSpace = true;
$doc->formatOutput = true;

echo $doc->saveXML();

__halt_compiler();
()<?php ()
