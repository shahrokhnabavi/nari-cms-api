<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Slim\App;
use Slim\Factory\AppFactory;

/**
 * @codeCoverageIgnore
 */
final class SlimServiceProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        App::class,
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(App::class, function (): App {
            return AppFactory::create();
        });
    }
}
