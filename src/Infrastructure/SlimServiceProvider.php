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
class SlimServiceProvider extends AbstractServiceProvider
{
    protected $provides = [App::class];

    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(App::class, function (): App {
            return AppFactory::create();
        });
    }
}
