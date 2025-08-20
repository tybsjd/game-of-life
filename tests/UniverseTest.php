<?php
declare(strict_types=1);

namespace GameOfLife\Tests;

use GameOfLife\Core\Universe;
use PHPUnit\Framework\TestCase;

final class UniverseTest extends TestCase
{
    public function testUnderpopulation(): void
    {
        $u = new Universe([[0,0]]); // single live cell
        $u->tick();
        $this->assertSame([], $u->liveCells(), 'Lonely cell should die.');
    }

    public function testSurvivalWithTwoOrThreeNeighbors(): void
    {
        $u = new Universe([[0,0],[0,1],[0,2]]);
        $u->tick();
        $this->assertEqualsCanonicalizing([[-1,1],[0,1],[1,1]], $u->liveCells());
        $u->tick();
        $this->assertEqualsCanonicalizing([[0,0],[0,1],[0,2]], $u->liveCells());
    }

    public function testReproductionWithThreeNeighbors(): void
    {
        $u = new Universe([[0,0],[1,0],[0,1]]);
        $u->tick();
        $this->assertContains([1,1], $u->liveCells(), 'A dead cell with 3 neighbors becomes alive.');
    }
}
