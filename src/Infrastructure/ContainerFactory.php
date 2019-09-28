<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure;

use League\Container\Container;
use Psr\Container\ContainerInterface;
use SiteApi\Infrastructure\Logging\LoggingServiceProvider;
use SiteApi\Infrastructure\Middleware\MiddlewareServiceProvider;

/**
 * @codeCoverageIgnore
 */
class ContainerFactory
{
    /**
     * @return ContainerInterface
     */
    public static function create(): ContainerInterface
    {
        $container = new Container();

        $container->addServiceProvider(SlimServiceProvider::class);
        $container->addServiceProvider(MiddlewareServiceProvider::class);
        $container->addServiceProvider(LoggingServiceProvider::class);

        return $container;
    }
}
