<?php

class Cell
{
    private bool $isAlive;

    public function __construct(bool $isAlive = true)
    {
        $this->isAlive = $isAlive;
    }

    public static function create(bool $isAlive = true): self
    {
        return new self($isAlive);
    }

    public function isAlive(): bool
    {
        return $this->isAlive;
    }
}
