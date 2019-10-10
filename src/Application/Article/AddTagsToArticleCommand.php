<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use SiteApi\Application\CommandBus\Command;

class AddTagsToArticleCommand extends Command
{
    /** @var int */
    private $articleId;

    /** @var array */
    private $tagIds;

    /**
     * @param int $articleId
     * @param array $tagIds
     */
    public function __construct(int $articleId, array $tagIds)
    {
        $this->articleId = $articleId;
        $this->tagIds = $tagIds;
    }

    /**
     * @return int
     */
    public function getArticleId(): int
    {
        return $this->articleId;
    }

    /**
     * @return array
     */
    public function getTagIds(): array
    {
        return $this->tagIds;
    }
}
