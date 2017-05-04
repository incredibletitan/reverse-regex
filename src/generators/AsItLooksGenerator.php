<?php

namespace src\generators;

/**
 * Class AsItLooksGenerator
 *
 * @author Yuriy Stos
 */
class AsItLooksGenerator implements RandomGenerator
{
    private $item;

    public function generate()
    {
        return $this->item;
    }

    public function addItem($item)
    {
        $this->item = $item;
    }
}