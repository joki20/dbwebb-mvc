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

        // check session is set
        $res = $game->startGame();
        $exp = $_SESSION['timeScored'] = 999;
        $this->assertEquals($_SESSION['timeScored'], 999);


        // when rolling a new game, check values are reset
        $res = $game->startGame();
    }
}
