<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

class HttpController
{
    /** @var ContainerInterface */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
    public function _get(string $name)
    {
        return $this->container->get($name);
    }
}
