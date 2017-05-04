<?php
require_once __DIR__ . '/../src/LexerAnalyzer.php';
require_once __DIR__ . '/../src/TokenIterator.php';
require_once __DIR__ . '/../src/Parser.php';
require_once __DIR__ . '/../src/RandomGenerator.php';
require_once __DIR__ . '/../src/RandomStringHelper.php';
require_once __DIR__ . '/../src/RandomCharacterGenerator.php';
require_once __DIR__ . '/../src/RandomCharacterSetGenerator.php';
require_once __DIR__ . '/../src/CharacterRangeSetParser.php';
require_once __DIR__ . '/../src/AsItLooksGenerator.php';
require_once __DIR__ . '/../src/SetParser.php';

$str = "foo [a-d]{2,9} [afs] [vs] baz";
$analyzer = new LexerAnalyzer($str);

$tokenIterator = $analyzer->getTokenIterator();
$parser = new Parser();
$parser->parse($tokenIterator);
echo $parser->getResultString();
