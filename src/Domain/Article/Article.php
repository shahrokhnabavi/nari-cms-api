<?php
declare(strict_types = 1);

namespace SiteApi\Domain\Article;

use Exception;
use InvalidArgumentException;
use SiteApi\Core\UUID;
use SiteApi\Domain\Tags\Tag;

class Article
{
    /** @var UUID */
    private $identifier;

    /** @var string */
    private $title;

    /** @var string */
    private $text;

    /** @var string */
    private $author;

    /** @var Tag[] */
    private $tags;

    /**
     * @param mixed[] $data
     *
     * @throws Exception
     */
    public function __construct(array $data)
    {
        if (empty($data['identifier'])) {
            throw new InvalidArgumentException('Article identifier should not be empty');
        }

        if (empty($data['title'])) {
            throw new InvalidArgumentException('Article title should not be empty');
        }

        $identifier = $data['identifier'] instanceof UUID ?
            $data['identifier'] :
            UUID::fromString($data['identifier']);

        $this->identifier = $identifier;
        $this->title = $data['title'];
        $this->text = $data['text'] ?? '';
        $this->author = $data['author'] ?? '';
        $this->tags = $this->loadTags($data['tags'] ?? []);
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

    /**
     * @return UUID
     */
    public function getIdentifier(): UUID
    {
        return $this->identifier;
    }

    /**
     * @param mixed[] $tagData
     *
     * @return Tag[]
     * @throws Exception
     */
    private function loadTags(array $tagData): array
    {
        $tags = [];

        foreach ($tagData as $tag) {
            $tags[] = new Tag($tag);
        }

        return $tags;
    }
}
