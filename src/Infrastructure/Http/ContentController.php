<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Http;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SiteApi\Application\Article\AddArticleCommand;
use SiteApi\Application\Article\AddTagsToArticleCommand;
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

        // do validation

        $identifier = (string)UUID::create();

        $articleCommand = new AddArticleCommand(
            $identifier,
            $params['title'],
            $params['text'] ?? '',
            $params['author'] ?? ''
        );
        $this->commandBus->handle($articleCommand);

        if (isset($params['tags']) && count($params['tags']) > 0) {
            $tagsCommand = new AddTagsToArticleCommand($identifier, $params['tags']);
            $this->commandBus->handle($tagsCommand);
        }

        // handle errors

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
