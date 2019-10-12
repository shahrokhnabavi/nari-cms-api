<?php
declare(strict_types = 1);

namespace Tests\Units\Domain\Article;

use InvalidArgumentException;
use SiteApi\Core\UUID;
use SiteApi\Domain\Article\Article;
use PHPUnit\Framework\TestCase;
use SiteApi\Domain\Tags\Tag;

class ArticleTest extends TestCase
{
    /** @var mixed[] */
    private $data = [
        'identifier' => 'e901845a-ed12-11e9-b2d0-985aebd8ae97',
        'title' => 'Article Title',
        'text' => 'This is my very first post',
        'author' => 'Shahrokh',
        'tags' => [
            [
                'identifier' => '4f5bc1d2-ec5c-11e9-81b4-2a2ae2dbcce4',
                'name' => 'PHP',
            ],
            [
                'identifier' => 'a42c05c8-ec5c-11e9-81b4-2a2ae2dbcce4',
                'name' => 'NodeJS'
            ],
        ],
    ];

    /**
     * @throws \Exception
     */
    public function testShouldInstantiateArticleModel()
    {
        $data = $this->data;
        $model = new Article($data);

        $this->assertEquals($data['title'], $model->getTitle());
        $this->assertEquals($data['text'], $model->getText());
        $this->assertEquals($data['author'], $model->getAuthor());
        $this->assertIsArray($model->getTags());
        $this->assertCount(2, $model->getTags());
        $this->assertInstanceOf(Tag::class, $model->getTags()[0]);
        $this->assertEquals($data['tags'][0]['name'], $model->getTags()[0]->getName());
    }

    /**
     * @throws \Exception
     */
    public function testShouldThrowInvalidArgumentExceptionIfArticleTitleIsNotPresent()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Article title should not be empty');

        new Article(['identifier' => 'e901845a-ed12-11e9-b2d0-985aebd8ae97', 'text' => 'hello']);
    }

    /**
     * @throws \Exception
     */
    public function testShouldThrowInvalidArgumentExceptionIfArticleIdentifierIsNotPresent()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Article identifier should not be empty');

        new Article(['text' => 'hello']);
    }

    /**
     * @throws \Exception
     */
    public function testShouldCreateArticleWithUuidIdentifierClass()
    {
        $data = $this->data;
        $data['identifier'] = UUID::create();

        $article = new Article($data);

        $this->assertEquals($data['identifier'], (string)$article->getIdentifier());
    }
}
