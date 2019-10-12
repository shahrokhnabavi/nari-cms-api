<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Article;

use Exception;
use SiteApi\Infrastructure\Pdo\WebsitePDO;
use SiteApi\Core\UUID;
use SiteApi\Domain\Article\Article;
use SiteApi\Domain\Article\ArticleAlreadyExistsException;
use SiteApi\Infrastructure\Pdo\PdoConnectionFactory;
use SiteApi\Infrastructure\Pdo\PdoCredentialException;

class PdoArticleRepository
{
    /** @var WebsitePDO */
    private $pdo;

    /** @var PdoTagRepository */
    private $tagRepository;

    /**
     * @param PdoConnectionFactory $pdoConnection
     *
     * @throws PdoCredentialException
     */
    public function __construct(PdoConnectionFactory $pdoConnection)
    {
        $this->pdo = $pdoConnection->createConnectionBySource('website');
        $this->tagRepository = new PdoTagRepository($pdoConnection);
    }

    /**
     * @param Article $article
     *
     * @return void
     * @throws ArticleAlreadyExistsException
     * @throws Exception
     */
    public function createArticleTransaction(Article $article): void
    {
        $title = $article->getTitle();
        if ($this->getArticleByTitle($title)) {
            throw ArticleAlreadyExistsException::causedBy(
                sprintf('Article with the title "%s" already exists', $title)
            );
        }

        $this->pdo->beginTransaction();
        try {
            $this->createArticle($article);
            $this->tagRepository->addTagsToArticle($article->getIdentifier(), $article->getTags());

            $this->pdo->commit();
        } catch (Exception $exception) {
            $this->pdo->rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @return PdoTagRepository
     */
    public function tagRepository(): PdoTagRepository
    {
        return $this->tagRepository;
    }

    /**
     * @param string $title
     *
     * @return Article|null
     * @throws Exception
     */
    public function getArticleByTitle(string $title): ?Article
    {
        $statement = $this->pdo->prepare('
            SELECT article_id as identifier, title, text, author FROM articles WHERE title = :title
        ');
        $statement->execute([':title' => $title]);

        $row = $statement->fetch();
        if (!$row) {
            return null;
        }

        return new Article($row);
    }

    /**
     * @param Article $article
     *
     * @return UUID
     */
    private function createArticle(Article $article): UUID
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO articles (article_id, title, text, author) VALUES (:id, :title, :text, :author)'
        );

        $statement->execute([
            ':id' => $article->getIdentifier(),
            ':title' => $article->getTitle(),
            ':text' => $article->getText(),
            ':author' => $article->getAuthor(),
        ]);

        return $article->getIdentifier();
    }
}
