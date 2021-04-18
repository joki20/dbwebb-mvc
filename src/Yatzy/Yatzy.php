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
    private array $numbers = ["Ettor","Tvåor","Treor","Fyror","Femmor","Sexor"];

    // start game
    public function yatzy()
    {
        isset($_SESSION['timesScored']) ? $_SESSION['timesScored'] : $_SESSION['timesScored'] = 0;
        isset($_SESSION['rolls']) ? $_SESSION['rolls'] + 1 : $_SESSION['rolls'] = 0;
        isset($_SESSION['lastRoll']) ? $_SESSION['lastRoll'] : $_SESSION['lastRoll'] = null;
        isset($_SESSION['Ettor']) ? $_SESSION['Ettor'] : $_SESSION['Ettor'] = null;
        isset($_SESSION['Tvåor']) ? $_SESSION['Tvåor'] : $_SESSION['Tvåor'] = null;
        isset($_SESSION['Treor']) ? $_SESSION['Treor'] : $_SESSION['Treor'] = null;
        isset($_SESSION['Fyror']) ? $_SESSION['Fyror'] : $_SESSION['Fyror'] = null;
        isset($_SESSION['Femmor']) ? $_SESSION['Femmor'] : $_SESSION['Femmor'] = null;
        isset($_SESSION['Sexor']) ? $_SESSION['Sexor'] : $_SESSION['Sexor'] = null;
        isset($_SESSION['sum']) ? $_SESSION['sum'] : $_SESSION['sum'] = null;
        isset($_SESSION['bonus']) ? $_SESSION['bonus'] : $_SESSION['bonus'] = null;
        isset($_SESSION['choice']) ? $_SESSION['choice'] : $_SESSION['choice'] = null;
        // create dice hand with 5 dice objects
        $_SESSION["dicehand"] = new DiceHand(5);
        $form = "";
        $rows = "";

        $start = '
                <!-- Start game -->
                <form method="POST" id="form-roll">
                    <input
                        type="submit"
                        name="status"
                        value="Nytt spel"
                        id="form-roll"
                    >
                </form>
        ';

        echo $start;

        // if post button was pressed:
        //check what kind of post status.
        //Also show points table
        if (isset($_POST["status"])) {
            switch($_POST["status"]) {
                case "Nytt spel":
                    $this->newGame();
                    echo $this->rollDice();
                    break;
                case "Slå tärningar":
                case "Sparade":
                    echo $this->rollDice();
                    break;
                    case "Slå tärningar":
                case "Score":
                    $this->score();
                    echo $this->rollDice();
                    break;
                default:
                    echo "HAHA";
                    break;
            }

            $scoreButton = "";
            if ($_SESSION["timesScored"] < 6) {
                $scoreButton = '<input type="submit" name="status" value="Score">';
            }

            // create all rows 1-6
            foreach ($this->numbers as $number) {
                $rows .= '
                <tr>
                    <td>
                    <input
                        type="radio"
                        name="choice"
                        value="' . $number . '" '
                        . (!is_null($_SESSION[$number]) ? ' disabled ' : null) . '
                    </td>
                    <td>' . $number . '</td>
                    <td> ' . $_SESSION[$number] . '  </td>
                </tr>
                ';
            }

            $form = '
            <form method="POST">
                <table>
                    <tr>
                        <th>Val</th>
                        <th>Alternativ</th>
                        <th>Poäng</th>
                    </tr>
                    ' . $rows . '
                    <tr><td>Bonus</td><td>' . $_SESSION['bonus'] . '</td></tr>
                    <tr><td>Summa</td><td>' . $_SESSION['sum'] . '</td></tr>
                </table>
                ' . $scoreButton . '
            </form>
            ';
        }
        echo $form;
    }

    public function newGame() {
        $_SESSION["timesScored"] = 0;
        $_SESSION["rolls"] = 0;
        $_SESSION["lastRoll"] = null;
        $_SESSION['Ettor'] = null;
        $_SESSION['Tvåor'] = null;
        $_SESSION['Treor'] = null;
        $_SESSION['Fyror'] = null;
        $_SESSION['Femmor'] = null;
        $_SESSION['Sexor'] = null;
        $_SESSION['sum'] = null;
        $_SESSION['bonus'] = null;
        $_SESSION['choice'] = null;
    }

    public function rollDice() {
        // +1 to roll

        $_SESSION["rolls"] += 1;

        // WHEN ROLLING, TWO SCENARIOS. 1. NO DICES SAVED, 2. DICES SAVED
        if ($_SESSION["rolls"] <= 3) {
            // 1. NO DICES SAVED
            if (!isset($_POST["Sparade"])) {
                $_SESSION["lastRoll"] = $_SESSION["dicehand"]->getRolls();
                // CREATE 5 NUMBER STRING, i.e. 52632
                $_SESSION["lastRoll"] = str_replace(", ", "", $_SESSION["lastRoll"]);
            }

            // IF DICES SAVED, REROLL THOSE NOT SAVED
            if (isset($_POST['Sparade'])) {
                // array is created for multiple options
                $savedDiceIndexes = $_POST['Sparade'];
                for ($i = 0; $i < strlen($_SESSION["lastRoll"]); $i++) {
                        // those dices not saved, reroll them
                    if (!in_array($i, $savedDiceIndexes)) {
                        $_SESSION["lastRoll"][$i] = $_SESSION["dicehand"]->roll();
                    }
                }
            }
        }

        $diceRow = "";
        for ($i = 0; $i < strlen($_SESSION["lastRoll"]); $i++) {
            $diceRow .= '
                <td><p class=dice-utf8><i class=dice-' . $_SESSION["lastRoll"][$i] . '></i></p></td>';
        };

        $choiceRow = "";
        for ($i = 0; $i < strlen($_SESSION["lastRoll"]); $i++) {
            $choiceRow .= '
            <td>
                <input type=checkbox name=Sparade[] value=' . $i . '>
            </td>';
        };

        $rollButton = '<input type="submit" name="status" value="Slå tärningar">';
        if ($_SESSION["rolls"] >= 3 || $_SESSION["timesScored"] == 6) {
            $rollButton = '<input type="submit" name="status" value="Slå tärningar" disabled>';
        };



            // DICE CHOICE FOR REROLLS (dice row and choice row)
            return '
                <form method="POST">
                    <table>
                        <tr>' . $diceRow . '</tr>
                        <tr>' . $choiceRow . '</tr>
                    </table> '
               . $rollButton . '
               <br>
                </form>
            ';

    }

    public function score(): string {
        $_SESSION["timesScored"]++;
        // If scoring - reset rolls, save score, recalculate sum
        $_SESSION["rolls"] = 0;
        // save score
        switch ($_POST["choice"]) {
            case "Ettor":
                $_SESSION["Ettor"] = 1 * substr_count($_SESSION['lastRoll'], "1");
                break;
            case "Tvåor":
                $_SESSION["Tvåor"] = 2 * substr_count($_SESSION['lastRoll'], "2");
                break;
            case "Treor":
                $_SESSION["Treor"] = 3 * substr_count($_SESSION['lastRoll'], "3");
                break;
            case "Fyror":
                $_SESSION["Fyror"] = 4 * substr_count($_SESSION['lastRoll'], "4");
                break;
            case "Femmor":
                $_SESSION["Femmor"] = 5 * substr_count($_SESSION['lastRoll'], "5");
                break;
            case "Sexor":
                $_SESSION["Sexor"] = 6 * substr_count($_SESSION['lastRoll'], "6");
                break;
        }
        // recalculate sum
        $_SESSION['sum'] = (
            $_SESSION['Ettor'] +
            $_SESSION['Tvåor'] +
            $_SESSION['Treor'] +
            $_SESSION['Fyror'] +
            $_SESSION['Femmor'] +
            $_SESSION['Sexor']
            );

            // adding bonus
        if ($_SESSION["sum"] >= 63) {
            $_SESSION["bonus"] = 50;
        }

         $_SESSION["sum"] += $_SESSION["bonus"];

         return '
                 <br>
                 <form method="POST">
                     <input type="submit" name="status" value="Slå tärningar">
                 </form>
         ';
     }
}
