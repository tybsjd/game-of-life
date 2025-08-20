
# PHP Game of Life (CLI based)

A Game of Life implemented in PHP using an MVC structure and PSR-4 autoloading.

## Features

- MVC separation: Controller, Model holds state, View renders CLI output
- Infinite universe logic with bounded rendering
- Input validation + error handling
- Deterministic unit tests (PHPUnit)
- Demo uses a **Glider** centered in a 25x25 board
- Configurable board size, generations, tick delay

## Requirements

- PHP 8.1+
- Composer (for autoloading and running tests)

## Install & Run

```bash
composer install
composer dump-autoload
composer run start -- --width=25 --height=25 --generations=10 --tick=150
```

Arguments (all optional):

- `--width` (int ≥ 5) default: 25
- `--height` (int ≥ 5) default: 25
- `--generations` (int ≥ 1) default: 10
- `--tick` (int ms ≥ 0) default: 150

## Project Structure

```
bin/
  game.php
src/
  Controller/
    GameController.php
  Core/
    Coordinates.php
    Universe.php
  Model/
    Board.php
  View/
    CliRenderer.php
tests/
  UniverseTest.php
composer.json
README.md
```

## Notes

- The universe is logically infinite; we compute neighbors using a sparse set of live cells.
- Rendering is bounded to the requested width × height window.
- The Glider seed is placed at the visual center for demonstration.

## Running Tests

```bash
./vendor/bin/phpunit
# or
composer test
```

---
By Tayyab Sajjad
