<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\DiceHand;

/**
 * Test cases for class Guess.
 */
class DiceHandCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object is instance of DiceHand class
     */
    public function testCreateObject()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("App\Http\Controllers\DiceHand", $dice);
    }

    /**
     * Construct object and verify that there are correct amount of dices created
     */
    public function testGetDices()
    {
        $dice = new DiceHand(5);
        $this->assertInstanceOf("App\Http\Controllers\DiceHand", $dice);

        $res = count($dice->getDices());
        $exp = 5;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that there are correct amount of dices created
     */
    public function testChangeRolls()
    {
        $dice = new DiceHand(5);
        $this->assertInstanceOf("App\Http\Controllers\DiceHand", $dice);

        // old nr of rolls
        $res = count($dice->getDices());
        $exp = 5;
        $this->assertEquals($exp, $res);

        // new nr of rolls
        $res = $dice->changeRolls(10);
        $exp = 10;
        $this->assertEquals($exp, $res);
    }

    public function testGetRolls()
    {
        // thousand dices
        $dice = new DiceHand(1000);
        $this->assertInstanceOf("App\Http\Controllers\DiceHand", $dice);

        $exp = 1000; // 1000 results between 1-6 expected
        $rollResult = $dice->getRolls();
        $res = substr_count($rollResult, "1");
        $res += substr_count($rollResult, "2");
        $res += substr_count($rollResult, "3");
        $res += substr_count($rollResult, "4");
        $res += substr_count($rollResult, "5");
        $res += substr_count($rollResult, "6");
        $this->assertEquals($exp, $res);
    }

}
