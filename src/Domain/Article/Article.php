<?php
declare(strict_types = 1);

namespace SiteApi\Domain\Article;

use SiteApi\Domain\Tags\Tag;

class Article
{
    /** @var string */
    private $title;

    /** @var string */
    private $text;

    /** @var string */
    private $author;

    /** @var array|Tag[] */
    private $tags;

    /**
     * @param string $title
     * @param string $text
     * @param string $author
     * @param Tag[] $tags
     */
    public function __construct(
        string $title,
        string $text,
        string $author,
        array $tags
    ) {
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
        $this->tags = $tags;
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
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
