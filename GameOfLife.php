<?php

/**
 * Conway's Game of Life
 *
 * The world of the Game of Life is an infinite two-dimensional orthogonal grid of square "cells",
 * each of which is in one of two possible states, alive or dead.
 *
 * Rules:
 *   1. Any live cell with fewer than two live neighbours dies, as if by underpopulation.
 *   2. Any live cell with two or three live neighbours lives on to the next generation.
 *   3. Any live cell with more than three live neighbours dies, as if by overpopulation.
 *   4. Any dead cell with exactly three live neighbours becomes a live cell, as if by reproduction.
 */
class GameOfLife
{
    const MIN = 2;
    const MAX = 3;
    const SPAWN = 3;

    public $board;

    function __construct($boardState)
    {
        $this->board = $boardState;
    }

    function evolve()
    {
        $neighbourOffsets = [[-1, -1], [-1, 0], [-1, 1], [0, -1], [0, 1], [1, -1], [1, 0], [1, 1]];

        $newBoard = [];
        foreach ($this->board as $x => $row) {
            foreach ($row as $y => $cellState) {

                // count neighbouring living cells
                $neighbourCount = 0;
                foreach ($neighbourOffsets as [$xOffset, $yOffset]) {
                    if ($this->board[$x+$xOffset][$y+$yOffset] ?? false) {
                        $neighbourCount = $neighbourCount + 1;
                    }
                }

                // update the target cell based on GOL rules
                if ($cellState) {
                    $newState = $neighbourCount >= self::MIN && $neighbourCount <= self::MAX;
                } else {
                    $newState = $neighbourCount === self::SPAWN;
                }
                $newBoard[$x][$y] = $newState;
            }
        }

        $this->board = $newBoard;
    }

    function render()
    {
        echo "\e[H\e[J";

        $board = '';
        foreach ($this->board as $row) {
            foreach ($row as $cellState) {
                $board .= ' ' . ($cellState ? '▓▓' : '░░');
            }
            $board .= "\n";
        }

        echo "Game of Life";
        echo "\n\n$board\n";
        echo "Ctrl-C to quit...";

        sleep(1);
    }

    function run()
    {
        while (true) {
            $this->render();
            $this->evolve();
        }
    }
}

$boardState = [
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
];

(new GameOfLife($boardState))->run();
