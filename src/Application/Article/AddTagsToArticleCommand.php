<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use SiteApi\Application\CommandBus\Command;

class AddTagsToArticleCommand extends Command
{
    /** @var string */
    private $articleId;

    /** @var array */
    private $tagIds;

    /**
     * @param string $articleId
     * @param array $tagIds
     */
    public function __construct(string $articleId, array $tagIds)
    {
        $this->articleId = $articleId;
        $this->tagIds = $tagIds;
    }

    /**
     * @return string
     */
    public function getArticleId(): string
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
