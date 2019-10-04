<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\ErrorHandling;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
final class ErrorHandlingServiceProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        ErrorHandlingFactory::class
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(ErrorHandlingFactory::class, function () use ($container): ErrorHandlingFactory {
            return new ErrorHandlingFactory(
                $container->get(LoggerInterface::class)
            );
        });
    }
}
