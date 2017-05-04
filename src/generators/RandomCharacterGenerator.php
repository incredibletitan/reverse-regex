<?php

namespace src\generators;

/**
 * Class RandomCharacterGenerator
 *
 * @author Yuriy Stos
 */
class RandomCharacterGenerator implements RandomGenerator
{
    private $charactersList = [];

    public function generate()
    {
        return $this->charactersList[mt_rand(0, count($this->charactersList) - 1)];
    }

    public function addItem($item)
    {
        $this->charactersList[] = $item;
    }
}