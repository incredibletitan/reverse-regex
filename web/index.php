<?php
require_once __DIR__ . '/../src/LexerAnalyzer.php';
require_once __DIR__ . '/../src/TokenIterator.php';
require_once __DIR__ . '/../src/Parser.php';
require_once __DIR__ . '/../src/RandomGenerator.php';
require_once __DIR__ . '/../src/AsItLooksGenerator.php';

$str = "foo [bar] baz";
$analyzer = new LexerAnalyzer($str);

$tokenIterator = $analyzer->getTokenIterator();
$parser = new Parser();
$parser->parse($tokenIterator);
echo $parser->getResultString();
