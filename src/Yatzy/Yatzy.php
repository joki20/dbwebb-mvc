<?php

declare(strict_types=1);

namespace Joki20\Yatzy;

use Joki20\Dice\Dice;
use Joki20\GraphicalDice\GraphicalDice;
use Joki20\DiceHand\DiceHand;

use function Mos\Functions\url;

/**
 * Class Game21.
 */
class Yatzy
{
    // start game
    public function startGame()
    {
        // set Sessions

        isset($_SESSION['timesScored']) ? $_SESSION['timesScored'] : $_SESSION['timesScored'] = 0;
        isset($_SESSION['rolls']) ? $_SESSION['rolls'] + 1 : $_SESSION['rolls'] = 0;
        isset($_SESSION['lastRoll']) ? $_SESSION['lastRoll'] : $_SESSION['lastRoll'] = null;
        isset($_SESSION['ones']) ? $_SESSION['ones'] : $_SESSION['ones'] = null;
        isset($_SESSION['twos']) ? $_SESSION['twos'] : $_SESSION['twos'] = null;
        isset($_SESSION['threes']) ? $_SESSION['threes'] : $_SESSION['threes'] = null;
        isset($_SESSION['fours']) ? $_SESSION['fours'] : $_SESSION['fours'] = null;
        isset($_SESSION['fives']) ? $_SESSION['fives'] : $_SESSION['fives'] = null;
        isset($_SESSION['sixes']) ? $_SESSION['sixes'] : $_SESSION['sixes'] = null;
        isset($_SESSION['sum']) ? $_SESSION['sum'] : $_SESSION['sum'] = null;
        isset($_SESSION['bonus']) ? $_SESSION['bonus'] : $_SESSION['bonus'] = null;
        isset($_SESSION['choice']) ? $_SESSION['choice'] : $_SESSION['choice'] = null;
        ?>
        <!-- Start game -->
        <form method="POST" id="form-roll">
            <input
                type="submit"
                name="rolling"
                value="Nytt spel"
                id="form-roll"
            >
        </form>
        <?php


        // IF ROLLING A NEW GAME, RESET VALUES
        if (isset($_POST["rolling"]) && $_POST["rolling"] == "Nytt spel") {
            $_SESSION["timesScored"] = 0;
            $_SESSION["rolls"] = 0;
            $_SESSION["lastRoll"] = null;
            $_SESSION['ones'] = null;
            $_SESSION['twos'] = null;
            $_SESSION['threes'] = null;
            $_SESSION['fours'] = null;
            $_SESSION['fives'] = null;
            $_SESSION['sixes'] = null;
            $_SESSION['sum'] = null;
            $_SESSION['bonus'] = null;
            $_SESSION['choice'] = null;

            // create dice hand with 5 dice objects
            $_SESSION["dicehand"] = new DiceHand(5);
        }

        if (isset($_POST["score"])) {
            $_SESSION["timesScored"]++;
            // If scoring - reset rolls, save score, recalculate sum
            $_SESSION["rolls"] = 0;
            // save score
            switch ($_POST["choice"]) {
                case "ones":
                    $_SESSION["ones"] = 1 * substr_count($_SESSION['lastRoll'], "1");
                    break;
                case "twos":
                    $_SESSION["twos"] = 2 * substr_count($_SESSION['lastRoll'], "2");
                    break;
                case "threes":
                    $_SESSION["threes"] = 3 * substr_count($_SESSION['lastRoll'], "3");
                    break;
                case "fours":
                    $_SESSION["fours"] = 4 * substr_count($_SESSION['lastRoll'], "4");
                    break;
                case "fives":
                    $_SESSION["fives"] = 5 * substr_count($_SESSION['lastRoll'], "5");
                    break;
                case "sixes":
                    $_SESSION["sixes"] = 6 * substr_count($_SESSION['lastRoll'], "6");
                    break;
            }
            // recalculate sum
            $_SESSION['sum'] = (
                $_SESSION['ones'] +
                $_SESSION['twos'] +
                $_SESSION['threes'] +
                $_SESSION['fours'] +
                $_SESSION['fives'] +
                $_SESSION['sixes']
                );

                // adding bonus
            if ($_SESSION["sum"] >= 63) {
                $_SESSION["bonus"] = 50;
            }
                $_SESSION["sum"] += $_SESSION["bonus"];
        }

        // IF ROLLING
        if (isset($_POST["rolling"]) || isset($_POST["score"])) {
            // add +1 to roll
            $_SESSION["rolls"] = 1 + ($_SESSION["rolls"] ?? 0);


            // IF FIRST ROLL OR AFTER SCORE
            if (!isset($_POST['savedDice'])) {
                // roll all dice
                $_SESSION["lastRoll"] = $_SESSION["dicehand"]->getRolls();
                // create 5 number string i.e. 52612
                $_SESSION["lastRoll"] = str_replace(", ", "", $_SESSION["lastRoll"]);
            // IF DICES SAVED, REROLL SOME
            }
            if (isset($_POST['savedDice'])) {
                $savedDiceIndexes = $_POST['savedDice'];
                for ($i = 0; $i < strlen($_SESSION["lastRoll"]); $i++) {
                        // if dices are not saved, reroll them
                    if (!in_array($i, $savedDiceIndexes)) {
                        $_SESSION["lastRoll"][$i] = $_SESSION["dicehand"]->roll();
                    }
                }
            }
            ?>


            <!-- DICE CHOICE LOGIC FOR REROLLS-->
            <form method="POST">
                <table>
                    <tr>

                <?php
                for ($i = 0; $i < strlen($_SESSION["lastRoll"]); $i++) {
                    ?>
                    <td>
                        <p class='dice-utf8'><i class='dice-<?= $_SESSION["lastRoll"][$i] ?>'></i></p>
                    </td>
                    <?php
                }
                ?>
            </tr><tr>
                <?php
                for ($i = 0; $i < strlen($_SESSION["lastRoll"]); $i++) {
                    ?>
                    <td>
                        <input type="checkbox" name='savedDice[]' value='<?= $i ?>'>
                    </td>
                    <?php
                }
                ?>
            </tr>
            </table>
            <?php
            if (!isset($_POST["rolling"]) && !isset($_POST["score"]) || !isset($_POST["start"])) {
                if ($_SESSION["rolls"] < 3 && $_SESSION["timesScored"] < 6) {
                    ?>
                    <input type="submit" name="rolling" value="Slå igen">
                    <?php
                }
                if ($_SESSION["rolls"] >= 3 || $_SESSION["timesScored"] == 6) {
                    ?>
                    <input type="submit" name="rolling" value="Slå igen" disabled>
                    <?php
                };
                ?>

            </form>





                    <form method="POST">
                        <table>
                            <tr>
                                <th>Val</th>
                                <th>Alternativ</th>
                                <th>Poäng</th>
                            </tr>


                            <tr>
                                <td>
                                <input
                                    type="radio"
                                    name="choice"
                                    value="ones"
                                    <?php if (!is_null($_SESSION['ones'])) {
                                        ?> disabled <?php
                                    }
                                    ?>>
                                </td>
                                <td>
                                    Ettor
                                </td>
                                <td>
                                    <?= $_SESSION['ones'] ?>
                                </td>


                                <tr>
                                    <td>
                                    <input
                                        type="radio"
                                        name="choice"
                                        value="twos"
                                        <?php if (!is_null($_SESSION['twos'])) {
                                            ?> disabled <?php
                                        }
                                        ?>>
                                    </td>
                                    <td>
                                        Tvåor
                                    </td>
                                    <td>
                                        <?= $_SESSION['twos'] ?>
                                    </td>


                                    <tr>
                                        <td>
                                        <input
                                            type="radio"
                                            name="choice"
                                            value="threes"
                                            <?php if (!is_null($_SESSION['threes'])) {
                                                ?> disabled <?php
                                            }
                                            ?>>
                                        </td>
                                        <td>
                                            Treor
                                        </td>
                                        <td>
                                            <?= $_SESSION['threes'] ?>
                                        </td>


                                        <tr>
                                            <td>
                                            <input
                                                type="radio"
                                                name="choice"
                                                value="fours"
                                                <?php if (!is_null($_SESSION['fours'])) {
                                                    ?> disabled <?php
                                                }
                                                ?>>
                                            </td>
                                            <td>
                                                Fyror
                                            </td>
                                            <td>
                                                <?= $_SESSION['fours'] ?>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                            <input
                                                type="radio"
                                                name="choice"
                                                value="fives"
                                                <?php if (!is_null($_SESSION['fives'])) {
                                                    ?> disabled <?php
                                                }
                                                ?>>
                                            </td>
                                            <td>
                                                Femmor
                                            </td>
                                            <td>
                                                <?= $_SESSION['fives'] ?>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                            <input
                                                type="radio"
                                                name="choice"
                                                value="sixes"
                                                <?php if (!is_null($_SESSION['sixes'])) {
                                                    ?> disabled <?php
                                                }
                                                ?>>
                                            </td>
                                            <td>
                                                Sexor
                                            </td>
                                            <td>
                                                <?= $_SESSION['sixes'] ?>
                                            </td>
                                        </tr>
                            <tr><td>Bonus</td><td><?= $_SESSION['bonus'] ?></td></tr>
                            <tr><td>Summa</td><td><?= $_SESSION['sum'] ?></td></tr>
                        </table>
                <?php if ($_SESSION["timesScored"] < 6) { ?>
                            <input type="submit" name="score" value="Välj">
                <?php } ?>
                    </form>
                <?php
            }
        }
    }
}
