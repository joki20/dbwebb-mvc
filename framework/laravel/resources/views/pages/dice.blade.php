<?php
/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use App\Http\Controllers\Dice;

$header = $header ?? null;
$message = $message ?? null;

?>

<h1><?= $header ?></h1>

<?php session(['dice' => new Dice()]);

echo session('dice')->roll();

?>
