<?php

class Universe
{
    private World $world;
    private Engine $engine;
    private Renderer $renderer;

    public function __construct(World $world, Engine $engine, Renderer $renderer)
    {
        $this->world = $world;
        $this->engine = $engine;
        $this->renderer = $renderer;
    }

    private function tick(): void
    {
        $oldWorld = $this->world;
        $newWorld = $this->world->empty();

        foreach ($this->world->getMap() as $x => $row) {
            foreach ($row as $y => $cell) {
                $newCell = $this->engine->processCell($oldWorld, $cell, $x, $y);
                $newWorld->update($x, $y, $newCell);
            }
        }

        $this->world = $newWorld;
    }

    private function render(): void
    {
        $this->renderer::render($this->world);
    }

    public function bang(): void
    {
        while (true) {
            $this->render();
            $this->tick();
        }
    }
}
