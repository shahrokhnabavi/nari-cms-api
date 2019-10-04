<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure;

use League\Container\Container;
use Psr\Container\ContainerInterface;
use SiteApi\Infrastructure\Configuration\ConfigurationServiceProvider;
use SiteApi\Infrastructure\ErrorHandling\ErrorHandlingServiceProvider;
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

        $container->addServiceProvider(ErrorHandlingServiceProvider::class);
        $container->addServiceProvider(ConfigurationServiceProvider::class);
        $container->addServiceProvider(LoggingServiceProvider::class);
        $container->addServiceProvider(MiddlewareServiceProvider::class);
        $container->addServiceProvider(SlimServiceProvider::class);

        return $container;
    }
}
