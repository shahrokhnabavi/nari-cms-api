<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use Exception;
use PDO;
use SiteApi\Application\CommandBus\CommandHandlerInterface;
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
     * @throws Exception
     */
    public function handleAddArticleCommand(AddArticleCommand $articleCommand): void
    {
        $stat = $this->pdo->prepare('SELECT COUNT(*) FROM article WHERE title = :title');
        $stat->execute([':title' => $articleCommand->getTitle()]);

        if ($stat->fetchColumn() > 0) {
            throw new Exception('Article already exists');
        }

        $status = $this->pdo->prepare(
            'INSERT INTO article (title, text, author) VALUES (:title, :text, :author)'
        );

        $status->execute([
            ':title' => $articleCommand->getTitle(),
            ':text' => $articleCommand->getText(),
            ':author' => $articleCommand->getAuthor(),
        ]);
    }

    /**
     * @param AddTagsToArticleCommand $articleCommand
     *
     * @return void
     */
    public function handleAddTagsToArticleCommand(AddTagsToArticleCommand $articleCommand): void
    {
        // TODO add logic
        $articleCommand->getTagIds();
    }
}
