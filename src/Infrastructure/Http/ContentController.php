<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ContentController extends HttpController
{
    public function list(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->html($response, 'List');
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->html($response, 'get');
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->html($response, 'create');
    }

    public function edit(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->html($response, 'edit');
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->html($response, 'delete');
    }
}
