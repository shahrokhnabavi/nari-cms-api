<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use SiteApi\Application\CommandBus\Command;
use SiteApi\Core\UUID;

class AddTagToArticleCommand extends Command
{
    /** @var UUID */
    private $articleId;

    /** @var string */
    private $tagName;

    /**
     * @param UUID $articleId
     * @param string $tagName
     */
    public function __construct(UUID $articleId, string $tagName)
    {
        $this->articleId = $articleId;
        $this->tagName = $tagName;
    }

    /**
     * @return UUID
     */
    public function getArticleId(): UUID
    {
        return $this->articleId;
    }

    /**
     * @return string
     */
    public function getTagName(): string
    {
        return $this->tagName;
    }
}
