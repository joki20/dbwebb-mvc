<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use App\Http\Controllers\Yatzy; // class Yatzy

?>

@extends('layouts.app')
@section('content')

<h1>Yatzy</h1>

<?php session(['yatzy' => new Yatzy()]);

echo session('yatzy')->yatzy();

?>

@endsection
