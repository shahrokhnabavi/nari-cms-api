<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use SiteApi\Infrastructure\Configuration\ConfigurationInterface;
use SiteApi\Infrastructure\ErrorHandling\ErrorHandlingFactory;
use SiteApi\Infrastructure\Middleware\CorsMiddleware;
use SiteApi\Infrastructure\Middleware\JsonBodyParserMiddleware;
use SiteApi\Infrastructure\Middleware\JsonValidationMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;

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

        $container->add(App::class, function () use ($container): App {
            AppFactory::setContainer($container);
            $app = AppFactory::create();

            $app->add($container->get(JsonValidationMiddleware::class));
            $app->add($container->get(JsonBodyParserMiddleware::class));
            $app->add($container->get(CorsMiddleware::class));

            $config = $container->get(ConfigurationInterface::class);
            if ($config->get('environment') !== 'development') {
                $errorHandlerFactory = $container->get(ErrorHandlingFactory::class);

                $errorMiddleware = $app->addErrorMiddleware(true, true, true);
                $errorMiddleware->setDefaultErrorHandler($errorHandlerFactory->createBasicExceptionErrorHandler());
            }

            include APP_DIR . '/etc/routes/main.php';

            $app->addRoutingMiddleware();
            return $app;
        });
    }
}
