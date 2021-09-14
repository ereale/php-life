<?php

class Renderer
{
    private const ALIVE = '▓▓';
    private const DEAD = '░░';

    public static function render(World $world, int $delay = 1): void
    {
        self::clear();

        $board = '';
        foreach ($world->getMap() as $row) {
            foreach ($row as $cell) {
                $board .= ' ' . ($cell && $cell->isAlive() ? self::ALIVE : self::DEAD);
            }
            $board .= "\n";
        }

        echo "Game of Life";
        echo "\n\n$board\n";
        echo "Ctrl-C to quit...";

        sleep($delay);
    }

    private static function clear(): void
    {
        echo "\e[H\e[J";
    }
}
