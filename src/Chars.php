<?php

namespace DynamicTerminal;

class Chars implements \Iterator
{
    /**
     * @var array
     */
    private array $chars = [];
    /**
     * @var int
     */
    private int $position = 0;

    public function __construct(array $charList, bool $shuffle = true)
    {
        !$shuffle ?: shuffle($charList);;
        $this->chars = $charList;
    }

    public function current()
    {
        if ($this->valid()) {
            return $this->chars[$this->position];
        }

        return null;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->chars[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
