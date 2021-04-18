<?php

/**
 * Load the routes into the router, this file is included from
 * `htdocs/index.php` during the bootstrapping to prepare for the request to
 * be handled.
 */

declare(strict_types=1);

use FastRoute\RouteCollector;

global $router;

$router->addRoute("GET", "/test", function () {
    // A quick and dirty way to test the router or the request.
    return "Testing response";
});

// Mos\Controller \Index is a route going to root of application, solved by class Index
$router->addRoute("GET", "/", "\Mos20\Controller\Index");
$router->addRoute("GET", "/debug", "\Mos\Controller\Debug");
$router->addRoute("GET", "/twig", "\Mos\Controller\TwigView");

$router->addRoute("GET", "/game21", "\Mos\Controller\Game21");
$router->addRoute("POST", "/game21", "\Mos\Controller\Game21");

$router->addRoute("GET", "/yatzy", "\Mos\Controller\Yatzy");
$router->addRoute("POST", "/yatzy", "\Mos\Controller\Yatzy");

$router->addGroup("/session", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Session", "index"]);
    $router->addRoute("GET", "/destroy", ["\Mos\Controller\Session", "destroy"]);
});

$router->addGroup("/some", function (RouteCollector $router) {
    $router->addRoute("GET", "/where", ["\Mos\Controller\Sample", "where"]);
});

$router->addGroup("/form", function (RouteCollector $router) {
    $router->addRoute("GET", "/view", ["\Mos\Controller\Form", "view"]);
    $router->addRoute("POST", "/process", ["\Mos\Controller\Form", "process"]);
});









// declare(strict_types=1);
//
// namespace Mos\Router;
//
// use function Mos\Functions\{
//     destroySession,
//     redirectTo,
//     renderView,
//     renderTwigView,
//     sendResponse,
//     url
// };

/**
 * Class Router.
 */
// class Router
// {
//     public static function dispatch(string $method, string $path): void
//     {
//         if ($method === "GET" && $path === "/") {
//             $data = [
//                 "header" => "Start",
//                 "message" => "Välkommen, tryck på Game 21 för att börja spela.",
//             ];
//             $body = renderView("layout/index.php", $data);
//             sendResponse($body);
//             return;
//         } else if ($method === "GET" && $path === "/session") {
//             $body = renderView("layout/session.php");
//             sendResponse($body);
//             return;
//         } else if ($method === "GET" && $path === "/session/destroy") {
//             destroySession();
//             redirectTo(url("/session"));
//             return;
//         } else if ($method === "GET" && $path === "/debug") {
//             $body = renderView("layout/debug.php");
//             sendResponse($body);
//             return;
//         } else if ($method === "GET" && $path === "/twig") {
//             $data = [
//                 "header" => "Twig page",
//                 "message" => "Hey, edit this to do it youreself!",
//             ];
//             $body = renderTwigView("index.html", $data);
//             sendResponse($body);
//             return;
//         } else if ($method === "GET" && $path === "/some/where") {
//             $data = [
//                 "header" => "Rainbow page",
//                 "message" => "Hey, edit this to do it youreself!",
//             ];
//             $body = renderView("layout/page.php", $data);
//             sendResponse($body);
//             return;
//         } else if ($method === "GET" && $path === "/dice") {
//             $data = [
//                 "header" => "Dice page",
//                 // "message" => "Roll a dice on this page",
//             ];
//             $body = renderView("layout/dice.php", $data);
//             sendResponse($body);
//             return;
//         } else if ($method === "POST" && $path === "/dice") {
//             $data = [
//                 "header" => "Dice page",
//             ];
//             $body = renderView("layout/dice.php", $data);
//             sendResponse($body);
//             return;
//         } else if ($method === "GET" && $path === "/game21") {
//             $data = [
//                 "header" => "Game 21",
//                 "message" => "Roll a dice on this page",
//             ];
//             $body = renderView("layout/game21.php", $data);
//             sendResponse($body);
//             return;
//         } else if ($method === "POST" && $path === "/game21") {
//             $data = [
//                 "header" => "Game 21",
//                 "message" => "Roll a dice on this page",
//             ];
//             $body = renderView("layout/game21.php", $data);
//             sendResponse($body);
//             return;
//         }
//
//         $data = [
//             "header" => "404",
//             "message" => "The page you are requesting is not here. You may also checkout the HTTP response code, it should be 404.",
//         ];
//         $body = renderView("layout/page.php", $data);
//         sendResponse($body, 404);
//     }
// }
