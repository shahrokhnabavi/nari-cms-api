<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Article;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use SiteApi\Application\Article\ArticleCommandHandler;
use SiteApi\Infrastructure\Pdo\PdoConnectionFactory;

final class ArticleServiceProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        ArticleCommandHandler::class,
        PdoArticleRepository::class,
        PdoTagRepository::class
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(PdoArticleRepository::class, function () use ($container): PdoArticleRepository {
            $pdo = $container->get(PdoConnectionFactory::class);

            return new PdoArticleRepository($pdo);
        });

        $container->add(ArticleCommandHandler::class, function () use ($container): ArticleCommandHandler {
            $repository = $container->get(PdoArticleRepository::class);

            return new ArticleCommandHandler($repository);
        });
    }
}
