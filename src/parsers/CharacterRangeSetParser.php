<?php

namespace src\parsers;

use src\TokenIterator;
use src\LexerAnalyzer;
use src\generators\RandomCharacterSetGenerator;

/**
 * Class CharacterRangeSetParser
 *
 * Subparser for character range set
 *
 * @author Yuriy Stos
 */
class CharacterRangeSetParser
{
    /**
     * @param TokenIterator $iterator
     * @return RandomCharacterSetGenerator
     */
    public function parse(TokenIterator &$iterator)
    {
        $quantifierStart = 1;
        $quantifierEnd = 0;

        $rangeStart = $iterator->current()['value'];

        //skip dash
        $iterator->next();
        $iterator->next();

        $rangeEnd = $iterator->current()['value'];

        $iterator->next();

        if ($iterator->nextItem()['type'] === LexerAnalyzer::QUANTIFIER_OPEN) {
            $iterator->next();
            $iterator->next();

            $quantifierStartString = '';
            $quantifierEndString = '';

            while ($iterator->current()['type'] !== LexerAnalyzer::QUANTIFIER_CLOSE
                && $iterator->current()['value'] !== ','
            ) {
                if (is_numeric($quantifierStart = $iterator->current()['value'])) {
                    $quantifierStartString .= $quantifierStart;
                }
                $iterator->next();
            }

            if ($iterator->current()['value'] === ',') {
                $iterator->next();

                while ($iterator->current()['type'] !== LexerAnalyzer::QUANTIFIER_CLOSE) {
                    if (is_numeric($quantifierEnd = $iterator->current()['value'])) {
                        $quantifierEndString .= $quantifierEnd;
                    }
                    $iterator->next();
                }
            }
            $quantifierStart = (integer)$quantifierStartString;
            $quantifierEnd = (integer)$quantifierEndString;
        }
        return new RandomCharacterSetGenerator($rangeStart, $rangeEnd, $quantifierStart, $quantifierEnd);
    }
}