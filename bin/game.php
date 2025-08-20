#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use GameOfLife\Core\Universe;
use GameOfLife\Model\Board;
use GameOfLife\View\CliRenderer;
use GameOfLife\Controller\GameController;

// CLI Args & Validation
$options = getopt('', ['width::', 'height::', 'generations::', 'tick::']);
$width = isset($options['width']) ? intval($options['width']) : 25;
$height = isset($options['height']) ? intval($options['height']) : 25;
$generations = isset($options['generations']) ? intval($options['generations']) : 10;
$tick = isset($options['tick']) ? intval($options['tick']) : 150;

if ($width < 5 || $height < 5) {
    fwrite(STDERR, "Error: width and height must be >= 5.\n");
    exit(1);
}
if ($generations < 1) {
    fwrite(STDERR, "Error: generations must be >= 1.\n");
    exit(1);
}
if ($tick < 0) {
    fwrite(STDERR, "Error: tick must be >= 0ms.\n");
    exit(1);
}

// Seed: Glider centered
$cx = intdiv($width, 2);
$cy = intdiv($height, 2);
$seed = [
    [$cx - 1, $cy + 1],
    [$cx,     $cy - 1],
    [$cx,     $cy + 1],
    [$cx + 1, $cy],
    [$cx + 1, $cy + 1],
];

$universe = new Universe($seed);
$board = new Board($universe, $width, $height);

// Start from (0,0) so that the centered glider is visible.
$originX = 0;
$originY = 0;

$renderer = new CliRenderer('█', '-');
$controller = new GameController($board, $renderer, $tick);

try {
    $controller->run($generations, $originX, $originY);
} catch (Throwable $e) {
    fwrite(STDERR, "UnExpected error: " . $e->getMessage() . PHP_EOL);
    exit(1);
}
