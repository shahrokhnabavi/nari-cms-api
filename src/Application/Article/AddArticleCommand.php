<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use SiteApi\Application\CommandBus\Command;
use SiteApi\Core\UUID;

class AddArticleCommand extends Command
{
    /** @var UUID */
    private $identifier;

    /** @var string */
    private $title;

    /** @var string */
    private $text;

    /** @var string */
    private $author;

    /** @var mixed[] */
    private $tags;

    /**
     * @param UUID $identifier
     * @param string $title
     * @param string $text
     * @param string $author
     * @param mixed[] $tags
     */
    public function __construct(UUID $identifier, string $title, string $text, string $author, array $tags)
    {
        $this->identifier = $identifier;
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
        $this->tags = $tags;
    }

    /**
     * @return UUID
     */
    public function getIdentifier(): UUID
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return mixed[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
