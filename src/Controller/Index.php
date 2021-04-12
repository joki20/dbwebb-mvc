<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

/**
 * Controller for the index route.
 */
class Index // instead of extends ControllerTrait, we use ControllerTrait
{
    use ControllerTrait; // refers to Mos\Controller\ControllerTrait.php

    public function __invoke(): ResponseInterface
    {
        $data = [
            "header" => "Index page",
            "message" => "Hello, this is the ddd page, rendered as a layout.",
        ];

        $body = renderView("layout/index.php", $data);

        return $this->response($body);
    }
}
