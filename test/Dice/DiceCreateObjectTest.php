<?php

namespace Joki20\Dice;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for class Guess.
 */
class DiceCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object is instance of Dice class
     */
    public function testCreateObject()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Joki20\Dice\Dice", $dice);
    }

    /**
     * Construct object and verify that the sides of dice has been changed
     */
    public function testChangeSides()
    {

        $dice = new Dice();
        $this->assertInstanceOf("\Joki20\Dice\Dice", $dice);

        $res = $dice->changeSides(12);
        $exp = "You have a 12-sided dice";
        $this->assertEquals($exp, $res);

        $res = $dice->getSides();
        $exp = 12;
        $this->assertEquals($exp, $res);
    }

    public function testGetLastRoll()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Joki20\Dice\Dice", $dice);

        $dice->roll();
        $res = $dice->getLastRoll();
        $exp = $dice->getLastRoll();

        $this->assertEquals($exp, $res);
    }
}
