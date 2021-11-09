<?php

error_reporting(E_ERROR | E_PARSE);

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
    const MIN = '2';
    const MAX = '3';
    const SPAWN = '3';

    public Board $board;

    private static $instance = null;

    private function __construct($boardState, $width, $height)
    {
        try {
            $board = new Board($boardState, $width, $height);
        } catch (Exception $e) {
            $board = Board::empty();
        }

        $this->board = $board;
    }

    static function load($boardState, $width, $height)
    {
        if (!self::$instance) {
            self::$instance = new GameOfLife($boardState, $width, $height);
        }

        return self::$instance;
    }

    function getCells()
    {
        return $this->board->array();
    }

    function setBoard($board)
    {
        $this->board = $board;
    }

    function evolve()
    {
        // clear the screen
        echo "\e[H\e[J";

        // display the board
        $board = '';
        foreach ($this->getCells() as $row) {
            foreach ($row as $cellState) {
                $board .= ' ' . ($cellState ? '▓▓' : '░░');
            }
            $board .= "\n";
        }
        echo "Game of Life";
        echo "\n\n$board\n";
        echo "Ctrl-C to quit...";

        // sleep 1 second
        sleep(1);

        // board neighbour cell offsets
        $neighbourOffsets = [[-1, -1], [-1, 0], [-1, 1], [0, -1], [0, 1], [1, -1], [1, 0], [1, 1]];

        $newBoard = [];
        foreach ($this->getCells() as $x => $row) {
            foreach ($row as $y => $cellState) {

                // count neighbouring living cells
                $neighbourCount = 0;
                foreach ($neighbourOffsets as [$xOffset, $yOffset])
                    if ($this->getCells()[$x+$xOffset][$y+$yOffset])
                        $neighbourCount = $neighbourCount + 1;

                $newBoard[$x][$y] = $cellState
                    ? $neighbourCount >= self::MIN && $neighbourCount <= self::MAX
                    : $neighbourCount == self::SPAWN;
            }
        }

        $this->board = new Board($newBoard);
    }

    function run()
    {
        while (true) {
            $this->evolve();
        }
    }
}

class Board
{
    function __construct($board = [], $width = 0, $height = 0)
    {
        $this->width = $width;
        $this->height = $height;
        $this->board = $board;

        if ($this->getWidth() > 100 or $this->getHeight() > 100) {
            throw new Exception('Board is too big');
        }
    }

    function getWidth()
    {
        return count($this->board[0]);
    }

    function getHeight()
    {
        return count($this->board);
    }

    function array()
    {
        return $this->board;
    }

    static function empty()
    {
        return new Board();
    }
}

// ======================
//          Main
// ======================

function playGameOfLife($boardState)
{
    (GameOfLife::load($boardState, count($boardState[0]), count($boardState)))->run();
}

function main()
{
    global $argv;

    if ($boardStateFile = $argv[1]) {
        $boardState = json_decode(file_get_contents($boardStateFile), true);
    } else {
        $boardState = [
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0],
            [0, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0],
            [0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0],
            [0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0],
            [0, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];
    }

    playGameOfLife($boardState);
}

main();
