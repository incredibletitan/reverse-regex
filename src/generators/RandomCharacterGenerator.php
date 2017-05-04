<?php

namespace src\generators;

/**
 * Class RandomCharacterGenerator
 *
 * Class for generating literals from specified list
 *
 * @author Yuriy Stos
 */
class RandomCharacterGenerator implements RandomGenerator
{
    /**
     * @var array - list of characters from which random word will be generated
     */
    private $charactersList = [];

    /**
     * @inheritdoc
     *
     * Generates random character from specified character list
     */
    public function generate()
    {
        return $this->charactersList[mt_rand(0, count($this->charactersList) - 1)];
    }

    /**
     * Add word to list
     *
     * @param $item
     */
    public function addItem($item)
    {
        $this->charactersList[] = $item;
    }
}