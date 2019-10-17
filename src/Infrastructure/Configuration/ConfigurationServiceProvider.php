<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Configuration;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Noodlehaus\Config;

final class ConfigurationServiceProvider extends AbstractServiceProvider
{
    /** string */
    const DIR = APP_DIR . '/etc/configs';

    /** @var string[] */
    protected $provides = [
        ConfigurationInterface::class,
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(ConfigurationInterface::class, function (): ConfigurationInterface {
            return new ConfigurationAdapter(
                Config::load(self::DIR . '/')
            );
        });
    }
}
