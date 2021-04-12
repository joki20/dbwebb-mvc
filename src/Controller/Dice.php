<?php

declare(strict_types=1);

namespace Mos\Controller;

// use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

/**
 * Controller for the dice route.
 */
class Dice
{
    use ControllerTrait;

    private $sides;
    private $lastRoll;

    // constructor
    public function __construct(int $sides = 6, int $lastRoll = null)
    {
        $this->sides = $sides;
        $this->lastRoll = $lastRoll;
    }

    // roll dice
    public function roll(): int
    {
        $this->lastRoll = rand(1, $this->sides);
        return $this->lastRoll;
    }

    // getter
    public function getLastRoll(): int
    {
        return $this->lastRoll;
    }

    // setter
    public function changeSides($sides): string
    {
        // if dice already exists, set new sides
        if ($sides != "start") {
            $this->sides = $sides;
        }
        return "You have a {$this->sides}-sided dice";
    }
}

// KLASSER
// * Under ditt eget namespace, skapa följande efter bästa förmåga:
// * Skapa en klass Dice.
// * Man skall kunna slå/kasta/rulla tärningen.
// * Man skall kunna hämta senaste slaget.
// * Det skall vara konfigurerbart hur många sidor tärningen har.
