<?php

class World
{
    private const NEIGHBOURS = [[-1, -1], [-1, 0], [-1, 1], [0, -1], [0, 1], [1, -1], [1, 0], [1, 1]];

    private array $map;
    private int $width;
    private int $height;

    private function __construct(int $width, int $height)
    {
        if ($width < 1 || $height < 1) {
            throw new Exception('World must have positive dimensions');
        }

        $this->width = $width;
        $this->height = $height;
        $this->map = array_fill(0, $width, array_fill(0, $height, null));
    }

    public static function load(array $cellStates, Cell $cellType): self
    {
        $world = new self(count($cellStates[0]), count($cellStates));

        foreach ($cellStates as $x => $row) {
            foreach ($row as $y => $isAlive) {
                $world->update($x, $y, $cellType::create($isAlive));
            }
        }

        return $world;
    }

    public function empty(): self
    {
        return new self($this->height, $this->width);
    }

    public function update(int $x, int $y, Cell $cell): void
    {
        if ($x < 0 || $x > $this->width-1 || $y < 0 || $y > $this->height-1) {
            throw new Exception('Out of bounds');
        }

        $this->map[$x][$y] = $cell;
    }

    public function countNeighbours(int $x, int $y): int
    {
        $neighbourCount = 0;
        foreach (self::NEIGHBOURS as [$xOffset, $yOffset]) {
            $cell = $this->findCell($x + $xOffset, $y + $yOffset);
            if ($cell && $cell->isAlive()) {
                $neighbourCount++;
            }
        }

        return $neighbourCount;
    }

    private function findCell(int $x, int $y): ?Cell
    {
        return $this->map[$x][$y] ?? null;
    }

    /**
     * @return Cell[][]
     */
    public function getMap(): array
    {
        return $this->map;
    }
}
