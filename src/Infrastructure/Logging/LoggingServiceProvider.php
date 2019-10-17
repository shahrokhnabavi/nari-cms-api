<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Logging;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Log\LoggerInterface;
use SiteApi\Infrastructure\Configuration\ConfigurationInterface;

final class LoggingServiceProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        LoggerInterface::class
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(LoggerInterface::class, function () use ($container): LoggerInterface {
            $config = $container->get(ConfigurationInterface::class);

            $loggerFactory = new LoggerFactory(
                $config->get('logger.name')
            );

            if ($config->get('environment') === 'development') {
                return $loggerFactory->createBasicFileLogger(
                    APP_DIR . $config->get('logger.path'),
                    $config->get('logger.level')
                );
            }

            return $loggerFactory->createPaperTrailAppLogger(
                $config->get('logger.papertrail.hostname'),
                $config->get('logger.papertrail.port'),
                $config->get('logger.level')
            );
        });
    }
}
