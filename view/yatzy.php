<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use Joki20\Yatzy\Yatzy; // class Yatzy

$header = $header ?? null;
$message = $message ?? null;

?><h1><?= $header ?></h1>

<?php $_SESSION["yatzy"] = new Yatzy();

echo $_SESSION["yatzy"]->yatzy();
