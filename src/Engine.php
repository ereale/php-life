<?php

class Engine
{
    private int $min;
    private int $max;
    private int $spawn;

    public function __construct(int $min, int $max, int $spawn)
    {
        $this->min = $min;
        $this->max = $max;
        $this->spawn = $spawn;
    }

    public function processCell(World $world, ?Cell $cell, int $x, int $y): Cell
    {
        $cellNeighbours = $world->countNeighbours($x, $y);

        if (!$cell->isAlive()) {
            $newState = $cellNeighbours === $this->spawn;
        } else {
            $newState = $cellNeighbours >= $this->min && $cellNeighbours <= $this->max;
        }

        return $cell::create($newState);
    }
}
