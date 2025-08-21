<?php
declare(strict_types=1);

namespace GameOfLife\Core;

/**
 * Object for integer grid coordinates.
 */
final class Coordinates
{
    public function __construct(
        public readonly int $x,
        public readonly int $y
    ) {
    }

    public function neighbors(): array
    {
        $n = [];
        for ($dx = -1; $dx <= 1; $dx++) {
            for ($dy = -1; $dy <= 1; $dy++) {
                if ($dx === 0 && $dy === 0) {
                    continue;
                }
                $n[] = new Coordinates($this->x + $dx, $this->y + $dy);
            }
        }
        return $n;
    }

    public function key(): string
    {
        return self::keyFrom($this->x, $this->y);
    }

    public static function keyFrom(int $x, int $y): string
    {
        return $x . ':' . $y;
    }
}
