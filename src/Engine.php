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
        $newState = $this->shouldLive($world, $cell, $x, $y);

        return $cell::create($newState);
    }

    private function shouldLive(World $world, ?Cell $cell, int $x, int $y): bool
    {
        $cellNeighbours = $world->countNeighbours($x, $y);

        if ($cell && $cell->isAlive()) {
            $newState = $cellNeighbours >= $this->min && $cellNeighbours <= $this->max;
        } else {
            $newState = $cellNeighbours === $this->spawn;
        }

        return $newState;
    }
}
