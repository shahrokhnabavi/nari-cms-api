<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Http;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SiteApi\Application\Article\AddArticleCommand;
use SiteApi\Application\Article\AddTagToArticleCommand;
use SiteApi\Application\Article\EditArticleCommand;
use SiteApi\Application\Article\RemoveArticleCommand;
use SiteApi\Application\Article\RemoveTagFromArticleCommand;
use SiteApi\Core\UUID;
use SiteApi\Infrastructure\Article\PdoArticleRepository;
use Throwable;

class ArticleController extends HttpController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function list(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->json($response, $this->getRepository()->getList());
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function get(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $article = $this->getRepository()->getArticleById(
            UUID::fromString($args['articleId'])
        );

        return $this->json($response, $article, empty($article) ? 404 : 200);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getParsedBody();

        try {
            $identifier = UUID::create();

            $command = new AddArticleCommand(
                $identifier,
                $params['title'],
                $params['text'] ?? '',
                $params['author'] ?? '',
                $params['tags'] ?? []
            );

            $this->commandBus->handle($command);
        } catch (Exception $exception) {
            return $this->handleErrors($response, $exception);
        }

        return $this->json($response, ['status' => 'success', 'identifier' => (string)$identifier]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $params = $request->getParsedBody();

        try {
            $identifier = UUID::fromString($args['articleId']);

            $command = new EditArticleCommand(
                $identifier,
                $params['title'],
                $params['text'] ?? '',
                $params['author'] ?? ''
            );

            $this->commandBus->handle($command);
        } catch (Exception $exception) {
            return $this->handleErrors($response, $exception);
        }

        return $this->json($response, ['status' => 'success', 'identifier' => (string)$identifier]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        try {
            $command = new RemoveArticleCommand(
                UUID::fromString($args['articleId'])
            );

            $this->commandBus->handle($command);
        } catch (Exception $exception) {
            return $this->handleErrors($response, $exception);
        }

        return $this->json($response, null, 202);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function addTagToArticle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ): ResponseInterface {
        $params = $request->getParsedBody();

        try {
            $command = new AddTagToArticleCommand(
                UUID::fromString($args['articleId']),
                $params['name']
            );

            $this->commandBus->handle($command);
        } catch (Exception $exception) {
            return $this->handleErrors($response, $exception);
        }

        return $this->json($response, null, 202);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function removeTagFromArticle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ): ResponseInterface {
        try {
            $command = new RemoveTagFromArticleCommand(
                UUID::fromString($args['articleId']),
                UUID::fromString($args['tagId'])
            );

            $this->commandBus->handle($command);
        } catch (Exception $exception) {
            return $this->handleErrors($response, $exception);
        }

        return $this->json($response, null, 202);
    }

    /**
     * @return PdoArticleRepository
     */
    private function getRepository(): PdoArticleRepository
    {
        return $this->getContainerEntry(PdoArticleRepository::class);
    }

    /**
     * @param ResponseInterface $response
     * @param Throwable $exception
     *
     * @return ResponseInterface
     */
    private function handleErrors(ResponseInterface $response, Throwable $exception): ResponseInterface
    {
        $response->getBody()->write($exception->getMessage());

        return $response->withStatus(400);
    }
}
