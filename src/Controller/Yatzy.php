<?php

declare(strict_types=1);

namespace Mos\Controller;

// use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

/**
 * Controller for the index route.
 */
class Yatzy
{
    use ControllerTrait;

    public function __invoke(): ResponseInterface
    {
        $data = [
            "header" => "Yatzy page",
            "message" => "Yatzy, this is the Game21 page, rendered as a layout.",
        ];

        $body = renderView("layout/yatzy.php", $data);

        return $this->response($body);
    }
}
