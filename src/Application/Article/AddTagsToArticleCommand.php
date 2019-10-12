<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use SiteApi\Application\CommandBus\Command;
use SiteApi\Core\UUID;
use SiteApi\Domain\Tags\Tag;

class AddTagsToArticleCommand extends Command
{
    /** @var UUID */
    private $articleId;

    /** @var Tag[] */
    private $tagIds;

    /**
     * @param UUID $articleId
     * @param Tag[] $tagIds
     */
    public function __construct(UUID $articleId, array $tagIds)
    {
        $this->articleId = $articleId;
        $this->tagIds = $tagIds;
    }

    /**
     * @return UUID
     */
    public function getArticleId(): UUID
    {
        return $this->articleId;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tagIds;
    }
}
