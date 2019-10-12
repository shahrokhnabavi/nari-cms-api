<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use SiteApi\Application\CommandBus\Command;
use SiteApi\Core\UUID;

class EditArticleCommand extends Command
{
    /** @var UUID */
    private $identifier;

    /** @var string */
    private $title;

    /** @var string */
    private $text;

    /** @var string */
    private $author;

    /**
     * @param UUID $identifier
     * @param string $title
     * @param string $text
     * @param string $author
     */
    public function __construct(UUID $identifier, string $title, string $text, string $author)
    {
        $this->identifier = $identifier;
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
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
    public function toArray(): array
    {
        return [
            'identifier' => $this->getIdentifier(),
            'title' => $this->getTitle(),
            'text' => $this->getText(),
            'author' => $this->getAuthor(),
        ];
    }
}
