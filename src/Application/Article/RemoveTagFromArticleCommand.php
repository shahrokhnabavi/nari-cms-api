<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use SiteApi\Application\CommandBus\Command;
use SiteApi\Core\UUID;

class RemoveTagFromArticleCommand extends Command
{
    /** @var UUID */
    private $articleId;

    /** @var UUID */
    private $tagId;

    /**
     * @param UUID $articleId
     * @param string $tagName
     */
    public function __construct(UUID $articleId, UUID $tagId)
    {
        $this->articleId = $articleId;
        $this->tagId = $tagId;
    }

    /**
     * @return UUID
     */
    public function getArticleId(): UUID
    {
        return $this->articleId;
    }

    /**
     * @return UUID
     */
    public function getTagId(): UUID
    {
        return $this->tagId;
    }
}
