<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure;

use League\Container\Container;
use Psr\Container\ContainerInterface;

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
        //$container->addServiceProvider(PdoServiceProvider::class);

        return $container;
    }
}
