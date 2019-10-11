<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use SiteApi\Application\CommandBus\Command;

class AddArticleCommand extends Command
{
    /** @var string */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $text;

    /** @var string */
    private $author;

    /**
     * @param string $id
     * @param string $title
     * @param string $text
     * @param string $author
     */
    public function __construct(string $id, string $title, string $text, string $author)
    {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
}
