<?php

declare(strict_types=1);

namespace Joki20\Game21;

use Joki20\Dice\Dice;
use Joki20\GraphicalDice\GraphicalDice;
use Joki20\DiceHand\DiceHand;

use function Mos\Functions\url;

/**
 * Class Game21.
 */
class Game21
{
    // start game
    public function game21()
    {
        ?>
        <form method="POST" id="form-roll">
            <input
                type="submit"
                name="start"
                value="Starta (om) spelet"
                id="form-roll"
                >
        </form>
        <?php

        // 1. START GAME
        if (isset($_POST["start"])) {
            $_SESSION["status"] = "choose";
            $_SESSION["playerScore"] = 0;
            $_SESSION["computerScore"] = 0;
            $_SESSION["playerRolls"] = 0;
            $_SESSION["computerRolls"] = 0;

            ?>
            <!-- 2. CHOOSE 1 OR 2 DICES -->
            <h2>Välj antal tärningar att spela med</p>

            <!-- 1 die -->
            <form method="POST">
                <input
                    type="submit" name="nrDices" value=1>
            </form>
            <!-- 2 dice -->
            <form method="POST">
                <input
                    type="submit" name="nrDices" value=2>
            </form>

            <?php
        // 3. SET NR OF DICES TO DICEHAND
        } elseif (isset($_POST["nrDices"])) {
            $nrDices = (int)$_POST["nrDices"];
            $_SESSION["diceHand"] = new DiceHand($nrDices);

            ?>
        <br>
        <!-- 4. BEGIN ROLLING DICE(S) -->
        <form method="POST">
            <input
                type="submit" name="roll" value="Rulla tärning">
        </form>

            <?php
        // 5. IF ROLL BUTTON IS PRESSED
        } elseif (isset($_POST["roll"])) {
            $rollResult = $_SESSION["diceHand"]->getRolls();
            echo $rollResult; // show result of dice
            $diceArray = explode(", ", $rollResult); // converts string of dice results to array
            $_SESSION["playerScore"] += array_sum($diceArray);
            $_SESSION["playerRolls"] += 1;
            // if sum is not 21 and you haven't stopped
            if ($_SESSION["playerScore"] < 21) {
                echo '<p>SUMMA: ' . $_SESSION["playerScore"] . '</p>';
                ?>
                <!-- 6. ROLL DICE AGAIN -->
                <form method="POST">
                    <input
                        type="submit" name="roll" value="Rulla tärning">
                </form>

                <!-- 7. OR STOP -->
                <form method="POST">
                    <input
                        type="submit" name="stop" value="Stanna">
                </form>
                <?php
            // If either 21 or more, or if you have stopped, do this:
            } elseif ($_SESSION["playerScore"] >= 21) {
                // if more than 21, game ends and you lose (computer doesn't play)
                if ($_SESSION["playerScore"] > 21) {
                         echo '<p>SUMMA: ' . $_SESSION["playerScore"] . '</p><p>GAME OVER!</p>';
                // if exactly 21
                } elseif ($_SESSION["playerScore"] == 21) {
                    echo '<p>SLUTPOÄNG: ' . $_SESSION["playerScore"] . '</p><p>GRATTIS!! :)</p>';

                    ?>
                        <br><br>
                        <!-- 8. COMPUTER's TURN -->
                        <form method="POST">
                            <input
                                type="submit" name="computer" value="Datorn">
                        </form>

                    <?php
                }
            }

          // 7. IF YOU ENDED YOUR TURNN BEFORE 21
        } elseif (isset($_POST["stop"])) {
               echo '<p>SLUTPOÄNG: ' . $_SESSION["playerScore"] . '</p><p>Klicka för datorns tur</p>';
            ?>
            <br><br>
            <!-- 8. COMPUTER's TURN -->
            <form method="POST">
                <input
                    type="submit" name="computer" value="Datorn">
            </form>
            <?php
        } elseif (isset($_POST["computer"])) {
            // if computer score is less than your score, continue rolling
            while ($_SESSION["computerScore"] < $_SESSION["playerScore"]) {
                $rollResult = $_SESSION["diceHand"]->getRolls();
                $diceArray = explode(", ", $rollResult); // converts string of dice results to array
                $_SESSION["computerScore"] += array_sum($diceArray);
                $_SESSION["computerRolls"] += 1;
            }

            if ($_SESSION["computerScore"] > 21) {
                echo "<p>YOU WON with score " . $_SESSION["playerScore"] . ", computer rolled over 21.</p>";
                echo "<p>You rolled " . $_SESSION["playerRolls"] . " times</p>";
                // if computer stopped at or before 21, it means it won over the player
            }

            if ($_SESSION["computerScore"] <= 21) {
                echo '<p>Computer won with score ' . $_SESSION["computerScore"] . '
                vs your score ' . $_SESSION["playerScore"] . '</p>';
                echo "<p>You rolled " . $_SESSION["playerRolls"] . " times</p>";
                echo "<p>Computer rolled " . $_SESSION["computerRolls"] . " times</p>";
            }
        }
    }
}
?>
