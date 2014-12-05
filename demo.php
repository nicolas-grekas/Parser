<?php

namespace Tchwork\Parser;

require 'vendor/autoload.php';

echo "Welcome the simple Demo Calculator\n";
echo "Please type your calculous:\n";

$parser = new Parser\DemoParser(
    new Lexer\DemoLexer(),
    new AstBuilder\DemoAstBuilder()
);

$parser->parse(STDIN);
