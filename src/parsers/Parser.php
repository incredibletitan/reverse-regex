<?php

namespace src\parsers;

use src\TokenIterator;
use src\LexerAnalyzer;
use src\generators\AsItLooksGenerator;
use src\generators\RandomGenerator;

/**
 * Class Parser
 *
 * @author Yuriy Stos
 */
class Parser
{
    /**
     * @var array - Random generators list
     */
    private $generatorsList = [];

    /**
     * Parses tokens and adds proper generators by token types
     *
     * @param TokenIterator $iterator
     */
    public function parse(TokenIterator $iterator)
    {
        while ($iterator->valid()) {
            if ($iterator->current()['type'] === LexerAnalyzer::LITERAL_CHAR) {
                $generator = new AsItLooksGenerator();
                $generator->addItem($iterator->current()['value']);
                $this->addItemToGeneratorList($generator);
            } elseif ($iterator->current()['type'] === LexerAnalyzer::SET_OPEN) {
                $iterator->next();

                if ($iterator->nextItem()['type'] === LexerAnalyzer::SET_RANGE) {
                    $this->addItemToGeneratorList((new CharacterRangeSetParser())->parse($iterator));
                } else {
                    $this->addItemToGeneratorList((new SetParser())->parse($iterator));
                }
            }
            $iterator->next();
        }
    }

    /**
     * Adds generators to list
     *
     * @param RandomGenerator $generator
     */
    private function addItemToGeneratorList(RandomGenerator $generator)
    {
        $this->generatorsList[] = $generator;
    }

    /**
     * Returns result string
     *
     * @return string
     */
    public function getResultString()
    {
        $resultString = '';

        foreach ($this->generatorsList as $randomGenerator) {
            $resultString .= $randomGenerator->generate();
        }
        return $resultString;
    }
}