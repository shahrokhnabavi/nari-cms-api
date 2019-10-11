<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use PDO;
use PDOException;
use SiteApi\Application\CommandBus\CommandHandlerInterface;
use SiteApi\Domain\Article\ArticleAlreadyExistsException;
use SiteApi\Infrastructure\Pdo\PdoConnectionFactory;
use SiteApi\Infrastructure\Pdo\PdoCredentialException;

class ArticleCommandHandler implements CommandHandlerInterface
{
    /** @var PDO */
    private $pdo;

    /**
     * @param PdoConnectionFactory $pdo
     *
     * @throws PdoCredentialException
     */
    public function __construct(PdoConnectionFactory $pdo)
    {
        $this->pdo = $pdo->createConnectionBySource('website');
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
     * @throws ArticleAlreadyExistsException
     */
    public function handleAddArticleCommand(AddArticleCommand $articleCommand): void
    {
        $statement = $this->pdo->prepare('SELECT COUNT(*) FROM articles WHERE title = :title');
        $statement->execute([':title' => $articleCommand->getTitle()]);

        if ($statement->fetchColumn() > 0) {
            throw ArticleAlreadyExistsException::causedBy(
                sprintf('Article with the title "%s" already exists', $articleCommand->getTitle())
            );
        }

        try {
            $statement = $this->pdo->prepare(
                'INSERT INTO articles (article_id, title, text, author) VALUES (:id, :title, :text, :author)'
            );

            $statement->execute([
                ':id' => $articleCommand->getId(),
                ':title' => $articleCommand->getTitle(),
                ':text' => $articleCommand->getText(),
                ':author' => $articleCommand->getAuthor(),
            ]);
        } catch (PDOException $exception) {
            // log
        }
    }

    /**
     * @param AddTagsToArticleCommand $articleCommand
     *
     * @return void
     */
    public function handleAddTagsToArticleCommand(AddTagsToArticleCommand $articleCommand): void
    {
        $this->pdo->beginTransaction();

        foreach ($articleCommand->getTagIds() as $tagId) {
            $statment = $this->pdo->prepare('
                INSERT INTO articles_tags (`article_id`, `tag_id`) VALUE (:articleId, :tagId)
            ');

            $statment->execute([
                ':articleId' => $articleCommand->getArticleId(),
                ':tagId' => $tagId
            ]);
        }

        $this->pdo->commit();
    }
}
