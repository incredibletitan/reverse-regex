<?php

/**
 * Class RandomCharacterSetGenerator
 *
 * @author Yuriy Stos
 */
class RandomCharacterSetGenerator implements RandomGenerator
{
    private $rangeStart;
    private $rangeEnd;
    private $quantifierStart;
    private $quantifierEnd;

    public function __construct($rangeStart, $rangeEnd, $quantifierStart = 1, $quantifierEnd = 1)
    {
        $this->rangeStart = $rangeStart;
        $this->rangeEnd = $rangeEnd;
        $this->quantifierStart = $quantifierStart;
        $this->quantifierEnd = $quantifierEnd;
    }

    public function generate()
    {
        return RandomStringHelper::randomString(
            $this->rangeStart, $this->rangeEnd, $this->quantifierStart, $this->quantifierEnd
        );
    }
}