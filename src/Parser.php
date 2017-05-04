<?php

/**
 * Class Parser
 *
 * @author Yuriy Stos
 */
class Parser
{
    private $bracketsOpened = false;
    private $generatorsList = [];

    public function parse(TokenIterator $iterator)
    {
        while ($iterator->valid()) {
            if ($iterator->current()['type'] === LexerAnalyzer::T_LITERAL_CHAR
                && $this->bracketsOpened === false) {
                $generator = new AsItLooksGenerator();
                $generator->addItem($iterator->current()['value']);
                $this->addItemToGeneratorList($generator);
            } elseif ($iterator->current()['type'] === LexerAnalyzer::T_SET_OPEN) {
                $iterator->next();

                if ($iterator->nextItem()['type'] === LexerAnalyzer::T_SET_RANGE) {
                    $this->addItemToGeneratorList((new CharacterRangeSetParser())->parse($iterator));
                } else {
                    $this->addItemToGeneratorList((new SetParser())->parse($iterator));
                }
            }
            $iterator->next();
        }
    }

    private function addItemToGeneratorList(RandomGenerator $generator)
    {
        $this->generatorsList[] = $generator;
    }

    public function getResultString()
    {
        $resultString = '';

        foreach ($this->generatorsList as $randomGenerator) {
            $resultString .= $randomGenerator->generate();
        }

        return $resultString;
    }
}