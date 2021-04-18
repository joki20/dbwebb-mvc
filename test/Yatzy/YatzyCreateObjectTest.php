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
    public function testCreateYatzyInstance()
    {
        $game = new Yatzy();
        $this->assertInstanceOf("\Joki20\Yatzy\Yatzy", $game);

        // check session is set
        $res = $game->yatzy();
        $exp = $_SESSION['timesScored'] = 999;
        $this->assertEquals($_SESSION['timesScored'], 999);

        $_POST["status"] = "Nytt spel";
        $res = $game->yatzy();
        $exp = null;
        $this->assertEquals($res, $exp);

        $_POST["status"] = "Sparade";
        $res = $game->yatzy();
        $exp = null;
        $this->assertEquals($res, $exp);


        $_POST["status"] = "Score";
        $_POST["choice"] = "Ettor";
        $res = $game->yatzy();
        $exp = null;
        $this->assertEquals($res, $exp);
    }

    public function testRollDice() {
        $game = new Yatzy();

        $_SESSION["dicehand"] = new Yatzy;
        // prepare variables
        $_SESSION["lastRoll"] = "24363";
        $_POST["Sparade"] = [0,1,2];
        $savedDiceIndexes = $_POST["Sparade"];

        // check dice with index 0, 1, 2 are the same as before
        $game->rollDice();
        $res = $_SESSION["lastRoll"][0];
        $exp = 2;
        $this->assertEquals($res, $exp);

        $res = $_SESSION["lastRoll"][1];
        $exp = 4;
        $this->assertEquals($res, $exp);

        $res = $_SESSION["lastRoll"][2];
        $exp = 3;
        $this->assertEquals($res, $exp);

        $_SESSION["rolls"] = 3;
        $_SESSION["timesScored"] = 6;
        $res = $game->rollDice();
        $exp = '<input type="submit" name="status" value="Slå tärningar" disabled>';
        $this->assertStringContainsString($exp, $res);
    }

    public function testScore() {
        $game = new Yatzy();
        $_SESSION['lastRoll'] = "14436";
        $_POST["choice"] = "Tvåor";
        $game->score();
        $exp = 0;
        $this->assertEquals($_SESSION["Tvåor"], $exp);

        $_POST["choice"] = "Treor";
        $game->score();
        $exp = 3;
        $this->assertEquals($_SESSION["Treor"], $exp);

        $_POST["choice"] = "Fyror";
        $game->score();
        $exp = 8;
        $this->assertEquals($_SESSION["Fyror"], $exp);

        $_POST["choice"] = "Femmor";
        $game->score();
        $exp = 0;
        $this->assertEquals($_SESSION["Femmor"], $exp);

        $_POST["choice"] = "Sexor";
        $game->score();
        $exp = 6;
        $this->assertEquals($_SESSION["Sexor"], $exp);

        $_SESSION["Ettor"] = 6;
        $_SESSION["Tvåor"] = 8;
        $_SESSION["Treor"] = 12;
        $_SESSION["Fyror"] = 20;
        $_SESSION["Femmor"] = 25;
        $_SESSION["Sexor"] = 24;
        $_SESSION["bonus"] = 0;
        $game->score();
        $exp = 50;

        $this->assertEquals($_SESSION["bonus"], $exp);

    }
}
