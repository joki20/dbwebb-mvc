<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use Joki20\Game21\Game21;

$header = $header ?? null;
$message = $message ?? null;

?><h1><?= $header ?></h1>

<?php $_SESSION["game21"] = new Game21();

echo $_SESSION["game21"]->game21();
