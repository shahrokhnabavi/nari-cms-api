<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Article;

use Exception;
use InvalidArgumentException;
use SiteApi\Domain\Article\ArticleNotFoundException;
use SiteApi\Domain\Article\Articles;
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
     * @return Articles
     */
    public function getList(): Articles
    {
        $statement = $this->pdo->prepare('
            SELECT
                a.article_id as identifier,
                a.title, 
                a.text,
                a.author,
                t.tag_id as tagId,
                t.name as tagName 
            FROM articles a
            LEFT JOIN articles_tags at ON a.article_id = at.article_id
            LEFT JOIN tags t ON at.tag_id = t.tag_id
        ');
        $statement->execute();

        $records = $statement->fetchAll() ?? [];

        return new Articles($records);
    }

    /**
     * @param UUID $uuid
     *
     * @return Article
     * @throws ArticleNotFoundException
     * @throws Exception
     */
    public function getArticleById(UUID $uuid): Article
    {
        $statement = $this->pdo->prepare('
            SELECT
                a.article_id as identifier,
                a.title, 
                a.text,
                a.author,
                t.tag_id as tagId,
                t.name as tagName 
            FROM articles a
            LEFT JOIN articles_tags at ON a.article_id = at.article_id
            LEFT JOIN tags t ON at.tag_id = t.tag_id
            WHERE a.article_id = :articleId
        ');
        $statement->execute([':articleId' => (string)$uuid]);

        $records = $statement->fetchAll();
        if (empty($records)) {
            throw ArticleNotFoundException::causedBy(
                sprintf('Article with the identifier "%s" not found', $uuid)
            );
        }

        $tags = [];
        foreach ($records as $record) {
            if (empty($record['tagId'])) {
                continue;
            }

            $tags[] = [
                'identifier' => $record['tagId'],
                'name' => $record['tagName'],
            ];
        }

        $records[0]['tags'] = $tags;

        return new Article($records[0]);
    }

    /**
     * @param UUID $identifier
     * @param string $title
     * @param string $text
     * @param string $author
     * @param mixed[] $tags
     *
     * @return void
     * @throws ArticleAlreadyExistsException
     * @throws PdoRepositoryException
     */
    public function addArticle(UUID $identifier, string $title, string $text, string $author, array $tags): void
    {
        if ($this->isArticleExistBy('title', $title)) {
            throw ArticleAlreadyExistsException::causedBy(
                sprintf('Article with the title "%s" already exists', $title)
            );
        }

        $this->pdo->beginTransaction();
        try {
            $statement = $this->pdo->prepare('
                INSERT INTO articles (article_id, title, text, author) 
                VALUES (:articleId, :title, :text, :author)
            ');

            $statement->execute([
                ':articleId' => $identifier,
                ':title' => $title,
                ':text' => $text,
                ':author' => $author,
            ]);

            $this->tags()->addTagsToArticle($identifier, $tags);

            $this->pdo->commit();
        } catch (Exception $exception) {
            $this->pdo->rollBack();
            throw PdoRepositoryException::causedBy($exception->getMessage());
        }
    }

    /**
     * @param UUID $articleId
     *
     * @return void
     * @throws ArticleNotFoundException
     * @throws PdoRepositoryException
     */
    public function deleteArticle(UUID $articleId): void
    {
        $article = $this->getArticleById($articleId);

        try {
            $statement = $this->pdo->prepare('DELETE FROM articles WHERE article_id = :articleId');

            $statement->execute([
                ':articleId' => $article->getIdentifier(),
            ]);
        } catch (Exception $exception) {
            throw PdoRepositoryException::causedBy($exception->getMessage());
        }
    }

    /**
     * @param UUID $identifier
     * @param string $title
     * @param string $text
     * @param string $author
     *
     * @return void
     * @throws PdoRepositoryException
     */
    public function editArticle(UUID $identifier, string $title, string $text, string $author): void
    {
        try {
            $this->checkTitleIfDuplicate($identifier, $title);

            $article = $this->getArticleById($identifier);

            $statement = $this->pdo->prepare('
                UPDATE articles SET
                    title = :title,
                    text = :text,
                    author = :author
                WHERE article_id = :articleId
            ');

            $statement->execute([
                ':articleId' => (string)$article->getIdentifier(),
                ':title' => empty($title) ? $article->getTitle() : $title,
                ':text' => empty($text) ? $article->getText() : $text,
                ':author' => empty($author) ? $article->getAuthor() : $author,
            ]);
        } catch (Exception $exception) {
            throw PdoRepositoryException::causedBy($exception->getMessage());
        }
    }

    /**
     * @return PdoTagRepository
     */
    public function tags(): PdoTagRepository
    {
        return $this->tagRepository;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return bool
     */
    private function isArticleExistBy(string $key, $value): bool
    {
        $columnsMap = [
            'id' => 'article_id',
            'title' => 'title'
        ];

        if (empty($columnsMap[$key])) {
            throw new InvalidArgumentException(
                sprintf('We can not find %s key to check if article exits', $key)
            );
        }

        $statement = $this->pdo->prepare("
            SELECT COUNT(*) FROM articles WHERE {$columnsMap[$key]} = :value
        ");
        $statement->execute([':value' => $value]);

        return $statement->fetchColumn() > 0;
    }

    /**
     * @param UUID $identifier
     * @param string $title
     *
     * @throws PdoRepositoryException
     */
    private function checkTitleIfDuplicate(UUID $identifier, string $title):void
    {
        $statement = $this->pdo->prepare('
                SELECT COUNT(*) FROM articles WHERE article_id != :articleId AND title = :title
            ');
        $statement->execute([
            ':articleId' => $identifier,
            ':title' => $title
        ]);

        if ($statement->fetchColumn() > 0) {
            throw PdoRepositoryException::causedBy(
                'There is an article already exists with the same title.'
            );
        }
    }
}
