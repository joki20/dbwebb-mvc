<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use Joki20\Dice\Dice;
use Joki20\GraphicalDice\GraphicalDice;
use Joki20\DiceHand\DiceHand;

$header = $header ?? null;
$message = $message ?? null;

// if not set, create new die
if (!isset($_SESSION["dice"])) {
    $_SESSION["dice"] = new Dice();
}

$die = $_SESSION["dice"];
?>
<p>
    <?php
    // if changing sides form was posted, show new sides dice, otherwise show old sides
    if (isset($_POST["sides"]) && $_POST["sides"] != '' && $_POST["sides"] != 0) {
        $sidesNow = intval($_POST["sides"]);
        echo $die->changeSides($sidesNow);
    } else {
        echo $die->changeSides(6); // start value
    }
    ?>
</p>

<!-- No action meaning form submits to itself and page reloads -->
<form method="POST" id="change" action="dice">
    <input id="sides" type="number" name="sides">
    <input type="submit" name="submit" value="Ändra sidor" id="change">
</form>

<br>
<br>

 <form method="POST" id="form-roll" action="dice">
     <input
         type="submit"
         name="roll"
         value="Slå tärning"
         id="form-roll"
         onsubmit="<?php $die->roll(); ?>">
 </form>

 <p>
        <?php
        // if dice was rolled
        if (isset($_POST["roll"])) {
            echo "Your last roll was " . $die->getLastRoll();
        }
        ?>
 </p>

<?php

$graphicalDice = new GraphicalDice();
?>
<h1>Rolling <?= $graphicalDice->getRolls() ?> graphic dice</h1>
<?= $graphicalDice->graphic() ?>

<?php
$diceHand = new DiceHand(8);
echo "NY TÄRNING";
?><br><br>
<?= $diceHand->getRolls() ?>
