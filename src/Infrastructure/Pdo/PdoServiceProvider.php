<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Pdo;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use SiteApi\Infrastructure\Configuration\ConfigurationInterface;

final class PdoServiceProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        PdoConnectionFactory::class,
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->share(PdoConnectionFactory::class, function () use ($container): PdoConnectionFactory {
            $configuration = $container->get(ConfigurationInterface::class);

            $credentialsManager = new PdoCredentialsManager();
            $credentialsManager->addCredentials(
                'website',
                new PdoCredentials(
                    $configuration->get('db.connections.website.dns'),
                    $configuration->get('db.connections.website.credentials.username'),
                    $configuration->get('db.connections.website.credentials.password'),
                    $configuration->get('db.connections.website.credentials.caFile')
                )
            );

            return new PdoConnectionFactory($credentialsManager);
        });
    }
}
