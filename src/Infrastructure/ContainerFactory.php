<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure;

use League\Container\Container;
use Psr\Container\ContainerInterface;
use SiteApi\Infrastructure\Article\ArticleServiceProvider;
use SiteApi\Infrastructure\CommandBus\CommandBusServiceProvider;
use SiteApi\Infrastructure\Configuration\ConfigurationServiceProvider;
use SiteApi\Infrastructure\ErrorHandling\ErrorHandlingServiceProvider;
use SiteApi\Infrastructure\Logging\LoggingServiceProvider;
use SiteApi\Infrastructure\Middleware\MiddlewareServiceProvider;
use SiteApi\Infrastructure\Pdo\PdoServiceProvider;

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

        $container->addServiceProvider(ArticleServiceProvider::class);
        $container->addServiceProvider(ErrorHandlingServiceProvider::class);
        $container->addServiceProvider(CommandBusServiceProvider::class);
        $container->addServiceProvider(ConfigurationServiceProvider::class);
        $container->addServiceProvider(LoggingServiceProvider::class);
        $container->addServiceProvider(MiddlewareServiceProvider::class);
        $container->addServiceProvider(PdoServiceProvider::class);
        $container->addServiceProvider(SlimServiceProvider::class);

        return $container;
    }
}
