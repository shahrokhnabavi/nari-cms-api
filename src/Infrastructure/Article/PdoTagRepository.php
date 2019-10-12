<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Article;

use Exception;
use SiteApi\Infrastructure\Pdo\WebsitePDO;
use SiteApi\Core\UUID;
use SiteApi\Domain\Tags\Tag;
use SiteApi\Infrastructure\Pdo\PdoConnectionFactory;
use SiteApi\Infrastructure\Pdo\PdoCredentialException;

class PdoTagRepository
{
    /** @var WebsitePDO */
    private $pdo;

    /**
     * @param PdoConnectionFactory $pdoConnection
     *
     * @throws PdoCredentialException
     */
    public function __construct(PdoConnectionFactory $pdoConnection)
    {
        $this->pdo = $pdoConnection->createConnectionBySource('website');
    }

    /**
     * @param UUID $articleId
     * @param mixed[] $tags
     *
     * @return void
     * @throws PdoRepositoryException
     */
    public function addTagsToArticle(UUID $articleId, array $tags): void
    {
        $this->pdo->beginTransaction();
        try {
            /** @var Tag $tag */
            foreach ($tags as $tag) {
                $this->attachTagToArticle(
                    $articleId,
                    $this->addTag($tag['name'])
                );
            }

            $this->pdo->commit();
        } catch (Exception $exception) {
            $this->pdo->rollBack();
            throw PdoRepositoryException::causedBy($exception->getMessage());
        }
    }

    /**
     * @param UUID $articleId
     * @param string $tag
     *
     * @throws PdoRepositoryException
     */
    public function addTagToArticle(UUID $articleId, string $tag): void
    {
        $this->pdo->beginTransaction();
        try {
            $this->attachTagToArticle(
                $articleId,
                $this->addTag($tag)
            );

            $this->pdo->commit();
        } catch (Exception $exception) {
            $this->pdo->rollBack();
            throw PdoRepositoryException::causedBy($exception->getMessage());
        }
    }

    /**
     * @param UUID $articleId
     * @param UUID $tagId
     *
     * @throws PdoRepositoryException
     */
    public function removeTagFromArticle(UUID $articleId, UUID $tagId): void
    {
        try {
            $statement = $this->pdo->prepare('
                DELETE FROM articles_tags WHERE `article_id` = :articleId AND `tag_id` = :tagId
            ');

            $statement->execute([
                ':articleId' => (string)$articleId,
                ':tagId' => (string)$tagId,
            ]);
        } catch (Exception $exception) {
            throw PdoRepositoryException::causedBy($exception->getMessage());
        }
    }

    /**
     * @param string $name
     *
     * @return Tag|null
     * @throws Exception
     */
    public function getTagByName(string $name): ?Tag
    {
        $statement = $this->pdo->prepare('
            SELECT tag_id as identifier, name FROM tags WHERE name = :name
        ');
        $statement->execute([':name' => strtolower($name)]);

        $row = $statement->fetch();
        if (!$row) {
            return null;
        }

        return new Tag($row);
    }

    /**
     * @param string $name
     *
     * @return UUID
     * @throws Exception
     */
    public function addTag(string $name): UUID
    {
        if ($tag = $this->getTagByName($name)) {
            return $tag->getIdentifier();
        }

        $identifier = UUID::create();

        $statement = $this->pdo->prepare('
            INSERT INTO tags (`tag_id`, `name`) VALUE (:tagId, :tagName)
        ');

        $statement->execute([
            ':tagId' => $identifier,
            ':tagName' => strtolower($name),
        ]);

        return $identifier;
    }

    /**
     * @param UUID $articleId
     * @param UUID $tagId
     *
     * @throws PdoRepositoryException
     */
    private function attachTagToArticle(UUID $articleId, UUID $tagId): void
    {
        try {
            $statement = $this->pdo->prepare('
                INSERT INTO articles_tags (`article_id`, `tag_id`) VALUE (:articleId, :tagId)
            ');

            $statement->execute([
                ':articleId' => (string)$articleId,
                ':tagId' => (string)$tagId,
            ]);
        } catch (Exception $exception) {
            throw PdoRepositoryException::causedBy('The tag already assigned to the article.');
        }
    }
}
