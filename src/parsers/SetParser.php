<?php

namespace src\parsers;

use src\generators\RandomCharacterGenerator;
use src\TokenIterator;
use src\LexerAnalyzer;

/**
 * Class SetParser
 *
 * @author Yuriy Stos
 */
class SetParser
{
    /**
     * @param TokenIterator $iterator
     * @return null|RandomCharacterGenerator
     */
    public function parse(TokenIterator &$iterator)
    {
        $resultGenerator = new RandomCharacterGenerator();

        while ($iterator->valid() && $iterator->current()['type'] !== LexerAnalyzer::T_SET_CLOSE) {
            $resultGenerator->addItem($iterator->current()['value']);
            $iterator->next();
        }
        return $resultGenerator;
    }
}