<?php

/**
 * Class CharacterRangeSetParser
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

        if ($iterator->nextItem()['type'] === LexerAnalyzer::T_QUANTIFIER_OPEN) {
            $iterator->next();
            $iterator->next();
            $quantifierStart = $iterator->current()['value'];
            $iterator->next();

            if ($iterator->current()['value'] === ',') {
                $iterator->next();
                $quantifierEnd = $iterator->current()['value'];
                $iterator->next();
            }
        }
        return new RandomCharacterSetGenerator($rangeStart, $rangeEnd, $quantifierStart, $quantifierEnd);
    }
}