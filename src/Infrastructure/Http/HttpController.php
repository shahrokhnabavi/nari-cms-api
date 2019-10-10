<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Http;

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
     * @param $text
     *
     * @return ResponseInterface
     */
    public function html(ResponseInterface $response, $text): ResponseInterface
    {
        $response->getBody()->write($text);

        return $response;
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
