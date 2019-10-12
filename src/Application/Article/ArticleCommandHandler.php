<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use Exception;
use SiteApi\Application\CommandBus\CommandHandlerInterface;
use SiteApi\Domain\Article\Article;
use SiteApi\Infrastructure\Article\PdoArticleRepository;

class ArticleCommandHandler implements CommandHandlerInterface
{
    /** @var PdoArticleRepository */
    private $repository;

    /**
     * @param PdoArticleRepository $repository
     */
    public function __construct(PdoArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return string[]
     */
    public static function handlesCommand(): array
    {
        return [
            AddArticleCommand::class,
            AddTagsToArticleCommand::class,
        ];
    }

    /**
     * @param AddArticleCommand $articleCommand
     *
     * @return void
     * @throws Exception
     */
    public function handleAddArticleCommand(AddArticleCommand $articleCommand): void
    {
        $this->repository->createArticleTransaction(
            new Article($articleCommand->toArray())
        );
    }

    /**
     * @param AddTagsToArticleCommand $articleCommand
     *
     * @return void
     * @throws Exception
     */
    public function handleAddTagsToArticleCommand(AddTagsToArticleCommand $articleCommand): void
    {
        $this->repository->tagRepository()->addTagsToArticle(
            $articleCommand->getArticleId(),
            $articleCommand->getTags()
        );
    }
}
