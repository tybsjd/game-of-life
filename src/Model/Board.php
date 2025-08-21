<?php
declare(strict_types=1);

namespace GameOfLife\Model;

use GameOfLife\Core\Universe;
use InvalidArgumentException;

/**
 * Bounded view-port over an infinite Universe.
 */
final class Board
{
    public function __construct(
        private Universe $universe,
        private int $width,
        private int $height
    ) {
        if ($width < 5 || $height < 5) {
            throw new InvalidArgumentException('Board dimension must be >= 5x5.');
        }
    }

    public function universe(): Universe
    {
        return $this->universe;
    }

    public function width(): int {
        return $this->width;
    }

    public function height(): int {
        return $this->height;
    }

    public function tick(): void
    {
        $this->universe->tick();
    }
}
