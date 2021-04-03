<?php

declare(strict_types=1);

namespace Joki20\DiceHand;

use Joki20\Dice\Dice;

/**
 * Class Dice.
 */
class DiceHand extends Dice
{

    private int $rolls = null;

    public function __construct(int $rolls = null)
    {

        $this->rolls  = $rolls;
        $this->dices = [];
        $this->values = [];

        for ($i = 0; $i < $this->rolls; $i++) {
            $this->dices[]  = new Dice();
            $this->values[] = null;
        }
    }

    // getter
    public function getRolls(): string
    {
        $results = "";
        for ($i = 0; $i < $this->rolls; $i++) {
            $this->dices[$i]->roll(); // roll die
            $this->values[$i] = $this->dices[$i]->getLastRoll(); // save result
        }
        return implode(", ", $this->values); // array to string
    }

    // setter
    public function changeRolls($rolls): int
    {
        $this->rolls = $rolls;
        return $this->rolls;
    }

    public function graphic(): string
    {
        $res = [];
        $class = [];
        $output = "";
        $sum = 0;
        for ($i = 0; $i < $this->getRolls(); $i++) {
            $res[$i] = $this->roll(); // roll dice
            $class[$i] = 'dice-' . $this->getLastRoll() ; // get result of roll
            $sum += $this->getLastRoll();
            $output .= '<i class=\'' . $class[$i] . '\'></i>';
        }
        return '<p class=\'dice-utf8\'>' . $output . '</p>';
    }
}

// * Skapa en klass DiceHand som kan innehålla ett antal tärningar.
// * Man kan konfigurera objektet hur många tärningar det skall innehålla.
// * Man kan rulla alla tärningar på en gång.
// * Man kan hämta värdena på de rullade tärningarna. -->
