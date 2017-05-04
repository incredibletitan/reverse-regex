<?php

namespace src\generators;

/**
 * Interface RandomGenerator
 * @package src\generators
 *
 * Interface for random generating classes
 */
interface RandomGenerator
{
    /**
     * Generates random string
     *
     * @return mixed
     */
    function generate();
}