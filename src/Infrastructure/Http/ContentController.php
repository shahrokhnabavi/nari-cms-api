<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SiteApi\Application\Article\AddArticleCommand;

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
        // Load payload
        // do validation

        $command = new AddArticleCommand('mola', 'rose', 'hora');
        $this->commandBus->handle($command);

        // handle errors

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
