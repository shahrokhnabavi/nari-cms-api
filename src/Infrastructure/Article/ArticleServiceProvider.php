<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Article;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use SiteApi\Application\Article\ArticleCommandHandler;
use SiteApi\Infrastructure\Pdo\PdoConnectionFactory;

/**
 * @codeCoverageIgnore
 */
final class ArticleServiceProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        ArticleCommandHandler::class,
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(ArticleCommandHandler::class, function () use ($container): ArticleCommandHandler {
            $pdo = $container->get(PdoConnectionFactory::class);

            return new ArticleCommandHandler($pdo);
        });
    }
}
