<?php

namespace Joki20\GraphicalDice;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

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
        $this->assertInstanceOf("\Joki20\GraphicalDice\GraphicalDice", $dice);
    }

    public function testGetRolls()
    {
        $dice = new GraphicalDice(6);
        $this->assertInstanceOf("\Joki20\GraphicalDice\GraphicalDice", $dice);

        $exp = 1;
        $res = $dice->getRolls();
        $this->assertEquals($exp, $res);
    }

    public function testGraphic()
    {
        $dice = new GraphicalDice(6);
        $this->assertInstanceOf("\Joki20\GraphicalDice\GraphicalDice", $dice);

        $res = $dice->graphic();
        $exp = "<i class";
        $this->assertStringContainsString($exp, $res); // $res should contain $exp
    }
}
