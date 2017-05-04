<?php

namespace src;

/**
 * Class TokenIterator
 *
 * Iterates tokens array
 *
 * @author Yuriy Stos
 */
class TokenIterator implements \Iterator
{
    /**
     * @var int - Current position
     */
    private $position = 0;

    /**
     * @var array - Tokens array
     */
    private $tokens;

    /**
     * TokenIterator constructor.
     * @param array $tokens - Tokens array
     */
    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * Resets current position
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Returns current element
     *
     * @return mixed
     */
    public function current()
    {
        return $this->tokens[$this->position];
    }

    /**
     * Returns next element
     *
     * @return mixed|null
     */
    public function nextItem()
    {
        return isset($this->tokens[$this->position + 1]) ? $this->tokens[$this->position + 1] : null;
    }

    /**
     * Returns current position
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Move position to next index
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Checks whether element exists
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->tokens[$this->position]);
    }
}