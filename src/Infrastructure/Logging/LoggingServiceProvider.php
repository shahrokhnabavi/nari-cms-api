<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Logging;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
final class LoggingServiceProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [LoggerInterface::class];

    /**
     * @return void
     */
    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(LoggerInterface::class, function () {
            // TODO: add config service
            $loggerFactory = new LoggerFactory('logger.name');

            if ('environment' === 'development' || true) {
                return $loggerFactory->createBasicFileLogger(
                    'logger.path',
                    'logger.level'
                );
            }

            return $loggerFactory->createPaperTrailAppLogger(
                'logger.hostname'
            );
        });
    }
}
