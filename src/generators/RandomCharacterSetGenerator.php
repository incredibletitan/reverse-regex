<?php

namespace src\generators;

use src\RandomStringHelper;

/**
 * Class RandomCharacterSetGenerator
 *
 * Class for generating range of random literals
 *
 * @author Yuriy Stos
 */
class RandomCharacterSetGenerator implements RandomGenerator
{
    /**
     * @var string - Range start value
     */
    private $rangeStart;

    /**
     * @var string - Range end value
     */
    private $rangeEnd;

    /**
     * @var integer - Quantifier minimal count of literals
     */
    private $quantifierStart;

    /**
     * @var integer - Quantifier maximum count of literals
     */
    private $quantifierEnd;

    public function __construct($rangeStart, $rangeEnd, $quantifierStart = 1, $quantifierEnd = 1)
    {
        $this->rangeStart = $rangeStart;
        $this->rangeEnd = $rangeEnd;
        $this->quantifierStart = $quantifierStart;
        $this->quantifierEnd = $quantifierEnd;
    }

    /**
     * @inheritdoc
     *
     * Generates random string by specified range and quantifiers
     *
     * E.g. [a-z]{5} - zsfrt;
     */
    public function generate()
    {
        return RandomStringHelper::randomString(
            $this->rangeStart, $this->rangeEnd, $this->quantifierStart, $this->quantifierEnd
        );
    }
}