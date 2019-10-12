<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Http;

use Exception;
use JsonSerializable;
use League\Tactician\CommandBus;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

class HttpController
{
    /** @var ContainerInterface */
    private $container;

    /** @var CommandBus */
    protected $commandBus;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->commandBus = $container->get(CommandBus::class);
    }

    /**
     * @param ResponseInterface $response
     * @param string $text
     *
     * @return ResponseInterface
     */
    public function html(ResponseInterface $response, string $text, int $statusCode = 200): ResponseInterface
    {
        $response->getBody()->write($text);

        return $response->withStatus($statusCode)
            ->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * @param ResponseInterface $response
     * @param mixed $data
     * @param int $statusCode
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function json(ResponseInterface $response, $data, int $statusCode = 200): ResponseInterface
    {
        if (is_array($data) || $data instanceof JsonSerializable) {
            $response->getBody()->write(json_encode($data));
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Json error');
        }

        return $response->withStatus($statusCode)
            ->withHeader('Content-Type', 'application/json');
    }

        /**
     * @param string $name
     *
     * @return mixed
     */
    public function getContainerEntry(string $name)
    {
        return $this->container->get($name);
    }
}
