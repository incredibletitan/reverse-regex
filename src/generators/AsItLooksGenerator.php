<?php

namespace src\generators;

/**
 * Class AsItLooksGenerator
 *
 * Returns literals as they exists. Use it for support literals without range
 *
 * @author Yuriy Stos
 */
class AsItLooksGenerator implements RandomGenerator
{
    /**
     * @var string
     */
    private $item;

    /**
     * @inheritdoc
     *
     * In that case, simply returns $this->item
     */
    public function generate()
    {
        return $this->item;
    }

    /**
     * Adds an item
     *
     * @param $item
     */
    public function addItem($item)
    {
        $this->item = $item;
    }
}