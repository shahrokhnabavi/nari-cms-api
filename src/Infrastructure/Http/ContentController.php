<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Http;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SiteApi\Application\Article\AddArticleCommand;
use SiteApi\Core\UUID;

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

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param mixed[] $args
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $params = $request->getParsedBody();

        try {
            $identifier = UUID::create();

            $articleCommand = new AddArticleCommand(
                $identifier,
                $params['title'],
                $params['text'] ?? '',
                $params['author'] ?? '',
                $params['tags'] ?? []
            );

            $this->commandBus->handle($articleCommand);
        } catch (Exception $exception) {
            $response->getBody()->write($exception->getMessage());

            return $response->withStatus(400);
        }

        return $this->html($response, 'create: ' . $identifier);
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
