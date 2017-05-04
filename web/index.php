<?php
require_once __DIR__ . '/../autoload.php';

use src\LexerAnalyzer;
use src\parsers\Parser;

$str = "f[uzkqe]ck [1-9]{40}";
$analyzer = new LexerAnalyzer($str);

$tokenIterator = $analyzer->getTokenIterator();
$parser = new Parser();
$parser->parse($tokenIterator);
echo $parser->getResultString();
