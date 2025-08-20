<?php
declare(strict_types=1);

namespace GameOfLife\Controller;

use GameOfLife\Model\Board;
use GameOfLife\View\CliRenderer;
use InvalidArgumentException;

final class GameController
{
    public function __construct(
        private Board $board,
        private CliRenderer $renderer,
        private int $tickMillis = 150
    ) {
        if ($tickMillis < 0) {
            throw new InvalidArgumentException('Tick must be >= 0ms.');
        }
    }

    public function run(int $generations, int $originX, int $originY): void
    {
        if ($generations < 1) {
            throw new InvalidArgumentException('Generations must be >= 1.');
        }

        for ($g = 1; $g <= $generations; $g++) {

            $this->renderer->clearScreen();
            echo "Generation {$g}", PHP_EOL;
            $this->renderer->render($this->board, $originX, $originY);

            if ($g < $generations) {
                $this->board->tick();

                if ($this->tickMillis > 0) {
                     usleep($this->tickMillis * 1000);
                }
            }
        }
    }
}
