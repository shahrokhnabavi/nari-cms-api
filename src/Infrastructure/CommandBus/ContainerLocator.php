<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\CommandBus;

use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;
use Psr\Container\ContainerInterface;

class ContainerLocator implements HandlerLocator
{
    /** @var string[] */
    protected $handlers = [];

    /** @var ContainerInterface */
    private $container;

    /**
     * @param ContainerInterface $container
     * @param string[] $commandClassToHandlerMap
     */
    public function __construct(ContainerInterface $container, array $commandClassToHandlerMap)
    {
        $this->container = $container;
        $this->handlers = $commandClassToHandlerMap;
    }

    /**
     * @param string $commandName
     *
     * @return object
     */
    public function getHandlerForCommand($commandName)
    {
        if (!isset($this->handlers[$commandName])) {
            throw MissingHandlerException::forCommand($commandName);
        }

        $handler = $this->container->get(
            $this->handlers[$commandName]
        );

        return $handler;
    }
}
