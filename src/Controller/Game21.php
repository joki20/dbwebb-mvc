<?php

declare(strict_types=1);

namespace Mos\Controller;

// use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

/**
 * Controller for the index route.
 */
class Game21
{
    use ControllerTrait;

    public function __invoke(): ResponseInterface
    {
        $data = [
            "header" => "Game21 page",
            "message" => "Hello, this is the Game21 page, rendered as a layout.",
        ];

        $body = renderView("layout/game21.php", $data);

        return $this->response($body);
    }
}
