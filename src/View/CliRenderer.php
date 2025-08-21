<?php
declare(strict_types=1);

namespace GameOfLife\View;

use GameOfLife\Model\Board;

final class CliRenderer
{
    public function __construct(
        private string $aliveChar = '█',
        private string $deadChar = '*'
    ) {
    }

    public function clearScreen(): void
    {
        // Escape|Clear|Home Screen
        echo "\033[2J\033[H";
    }

    public function render(Board $board, int $originX, int $originY): void
    {
        $w = $board->width();
        $h = $board->height();
        $u = $board->universe();

        $columns = [];
        for ($y = 0; $y < $h; $y++) {
            $row = '';

            for ($x = 0; $x < $w; $x++) {
                $cellAlive = $u->isAlive($originX + $x, $originY + $y);
                $row .= $cellAlive ? $this->aliveChar : $this->deadChar;
            }
            $columns[] = $row;
        }
        echo implode(PHP_EOL, $columns), PHP_EOL;
    }
}
