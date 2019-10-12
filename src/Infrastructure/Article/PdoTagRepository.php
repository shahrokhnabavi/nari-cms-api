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
     * @param UUID $articleIdentifier
     * @param array $tags
     *
     * @return void
     * @throws Exception
     */
    public function addTagsToArticle(UUID $articleIdentifier, array $tags): void
    {
        $this->pdo->beginTransaction();
        try {
            /** @var Tag $tag */
            foreach ($tags as $tag) {
                $existedTag = $this->getTagByName($tag->getName());

                $tagId = $existedTag ? $existedTag->getIdentifier() : $this->createTag($tag);

                $statement = $this->pdo->prepare('
                    INSERT INTO articles_tags (`article_id`, `tag_id`) VALUE (:articleId, :tagId)
                ');

                $statement->execute([
                    ':articleId' => (string)$articleIdentifier,
                    ':tagId' => (string)$tagId,
                ]);
            }

            $this->pdo->commit();
        } catch (Exception $exception) {
            $this->pdo->rollBack();
            throw new Exception($exception->getMessage());
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
        $statement->execute([':name' => $name]);

        $row = $statement->fetch();
        if (!$row) {
            return null;
        }

        return new Tag($row);
    }

    /**
     * @param Tag $tag
     *
     * @return UUID
     */
    public function createTag(Tag $tag): UUID
    {
        $statement = $this->pdo->prepare('
            INSERT INTO tags (`tag_id`, `name`) VALUE (:tagId, :tagName)
        ');

        $statement->execute([
            ':tagId' => (string)$tag->getIdentifier(),
            ':tagName' => $tag->getName(),
        ]);

        return $tag->getIdentifier();
    }
}
