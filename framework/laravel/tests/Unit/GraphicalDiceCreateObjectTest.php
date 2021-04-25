<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\GraphicalDice;

/**
 * Test cases for class Guess.
 */
class GraphicalDiceCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object is instance of GraphicalDice class
     */
    public function testCreateObject()
    {
        $dice = new GraphicalDice(6);
        $this->assertInstanceOf("App\Http\Controllers\GraphicalDice", $dice);
    }

    public function testGetRolls()
    {
        $dice = new GraphicalDice(6);
        $this->assertInstanceOf("App\Http\Controllers\GraphicalDice", $dice);

        $exp = 1;
        $res = $dice->getRolls();
        $this->assertEquals($exp, $res);
    }

    public function testGraphic()
    {
        $dice = new GraphicalDice(6);
        $this->assertInstanceOf("App\Http\Controllers\GraphicalDice", $dice);

        $res = $dice->graphic();
        $exp = "<i class";
        $this->assertStringContainsString($exp, $res); // $res should contain $exp
    }
}
