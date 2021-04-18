<?php

namespace Joki20\Yatzy;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Joki20\Yatzy\Yatzy;

/**
 * Test cases for class Guess.
 */
class YatzyCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object is instance of Yatzy class
     */
    public function testCreateYatzyGame()
    {
        $game = new Yatzy();
        $this->assertInstanceOf("\Joki20\Yatzy\Yatzy", $game);
    }
}
