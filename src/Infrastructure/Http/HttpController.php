<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Http;

class HttpController
{
    public function html($response, $text)
    {
        $response->getBody()->write($text);
        return $response;
    }
}
