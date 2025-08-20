<?php
declare(strict_types=1);

namespace GameOfLife\Core;

use InvalidArgumentException;

/**
 * infinite universe of live cells.
 */
final class Universe
{
    /** @var array<string,bool> */
    private array $live;

    /**
     * @param array<int,array{int,int}> $seed list of [x,y] live cells
     */
    public function __construct(array $seed = [])
    {
        $this->live = [];
        foreach ($seed as $pair) {

            if (!is_array($pair) || count($pair) !== 2) {
                throw new InvalidArgumentException('Seed must be list of [x,y] integer pairs.');
            }
            [$x, $y] = $pair;

            if (!is_int($x) || !is_int($y)) {
                throw new InvalidArgumentException('Coordinates must be integers.');
            }
            $this->live[Coordinates::keyFrom($x, $y)] = true;
        }
    }

    public function isAlive(int $x, int $y): bool
    {
        return $this->live[Coordinates::keyFrom($x, $y)] ?? false;
    }

    /** @return array<int,array{int,int}> */
    public function liveCells(): array
    {
        $out = [];
        foreach (array_keys($this->live) as $key) {

            [$x, $y] = array_map('intval', explode(':', $key));
            $out[] = [$x, $y];
        }
        return $out;
    }

    public function tick(): void
    {
        $counts = [];
        // Count neighbors
        foreach ($this->live as $key => $_true) {

            [$x, $y] = array_map('intval', explode(':', $key));
            $c = new Coordinates($x, $y);
            // ensure current live cell is in counts with 0 (for survival check)
            $counts[$key] = $counts[$key] ?? 0;

            foreach ($c->neighbors() as $n) {

                $nk = $n->key();
                $counts[$nk] = ($counts[$nk] ?? 0) + 1;
            }
        }

        $next = [];
        // Rules implementation
        foreach ($counts as $key => $count) {

            $alive = isset($this->live[$key]);
            if ($alive) {
                if ($count === 2 || $count === 3) {
                    $next[$key] = true;
                }
            } else {
                if ($count === 3) {
                    $next[$key] = true;
                }
            }
        }

        $this->live = $next;
    }
}
