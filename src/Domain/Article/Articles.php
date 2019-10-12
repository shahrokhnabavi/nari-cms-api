<?php
declare(strict_types = 1);

namespace SiteApi\Domain\Article;

use JsonSerializable;

class Articles implements JsonSerializable
{
    /** @var mixed[] */
    private $rawRecords;

    /**
     * @param array $rawRecords
     */
    public function __construct(array $rawRecords)
    {
        $this->rawRecords = $rawRecords;
    }

    public function jsonSerialize()
    {
        return $this->parsedArticles();
    }

    /**
     * @return mixed[]
     */
    private function parsedArticles(): array
    {
        $parsedResult = [];
        foreach ($this->rawRecords as $article) {
            $tags = $parsedResult[$article['identifier']]['tags'] ?? [];

            if (!empty($article['tagId'])) {
                $tags[$article['tagId']] = $article['tagName'];
            }

            $parsedResult[$article['identifier']] = [
                'title' => $article['title'],
                'text' => $article['text'],
                'author' => $article['author'],
                'tags' => $tags,
            ];
        }

        return $parsedResult;
    }
}
