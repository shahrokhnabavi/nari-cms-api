<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use SiteApi\Application\CommandBus\CommandHandlerInterface;
use SiteApi\Domain\Article\ArticleAlreadyExistsException;
use SiteApi\Domain\Article\ArticleNotFoundException;
use SiteApi\Infrastructure\Article\PdoArticleRepository;
use SiteApi\Infrastructure\Article\PdoRepositoryException;

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
            AddTagToArticleCommand::class,
            EditArticleCommand::class,
            RemoveArticleCommand::class,
            RemoveTagFromArticleCommand::class,
        ];
    }

    /**
     * @param AddArticleCommand $command
     *
     * @return void
     * @throws ArticleAlreadyExistsException
     * @throws PdoRepositoryException
     */
    public function handleAddArticleCommand(AddArticleCommand $command): void
    {
        $this->repository->addArticle(
            $command->getIdentifier(),
            $command->getTitle(),
            $command->getText(),
            $command->getAuthor(),
            $command->getTags()
        );
    }

    /**
     * @param AddTagToArticleCommand $command
     *
     * @return void
     * @throws PdoRepositoryException
     */
    public function handleAddTagToArticleCommand(AddTagToArticleCommand $command): void
    {
        $this->repository->tags()->addTagToArticle(
            $command->getArticleId(),
            $command->getTagName()
        );
    }

    /**
     * @param RemoveArticleCommand $command
     *
     * @return void
     * @throws PdoRepositoryException
     * @throws ArticleNotFoundException
     */
    public function handleRemoveArticleCommand(RemoveArticleCommand $command): void
    {
        $this->repository->deleteArticle($command->getIdentifier());
    }

    /**
     * @param EditArticleCommand $command
     *
     * @return void
     * @throws PdoRepositoryException
     */
    public function handleEditArticleCommand(EditArticleCommand $command): void
    {
        $this->repository->editArticle(
            $command->getIdentifier(),
            $command->getTitle(),
            $command->getText(),
            $command->getAuthor()
        );
    }

    /**
     * @param RemoveTagFromArticleCommand $command
     *
     * @return void
     * @throws PdoRepositoryException
     * @throws ArticleNotFoundException
     */
    public function handleRemoveTagFromArticleCommand(RemoveTagFromArticleCommand $command): void
    {
        $this->repository->tags()->removeTagFromArticle(
            $command->getArticleId(),
            $command->getTagId()
        );
    }
}
