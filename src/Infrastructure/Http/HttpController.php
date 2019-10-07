<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HttpController
{
    public function html(ResponseInterface $response, $text)
    {
        $response->getBody()->write($text);

        return $response;
    }
}
