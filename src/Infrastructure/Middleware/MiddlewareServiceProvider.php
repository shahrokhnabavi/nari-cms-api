<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Middleware;

use JsonSchema\Validator;
use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Log\LoggerInterface;

final class MiddlewareServiceProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        JsonValidationMiddleware::class,
        JsonBodyParserMiddleware::class,
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(JsonBodyParserMiddleware::class, function () use ($container): JsonBodyParserMiddleware {
            return new JsonBodyParserMiddleware();
        });

        $container->add(JsonValidationMiddleware::class, function () use ($container): JsonValidationMiddleware {
            return new JsonValidationMiddleware(
                new Validator(),
                $container->get(LoggerInterface::class)
            );
        });
    }
}
