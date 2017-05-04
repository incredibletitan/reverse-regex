<?php

/**
 * Class TokenIterator
 *
 * @author Yuriy Stos
 */
class TokenIterator implements Iterator
{
    private $position = 0;
    private $tokens;

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

    public function current()
    {
        return $this->tokens[$this->position];
    }

    public function nextItem()
    {
        return isset($this->tokens[$this->position + 1]) ? $this->tokens[$this->position + 1] : null;
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->tokens[$this->position]);
    }
}