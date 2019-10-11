<?php
declare(strict_types = 1);

namespace Tests\Units\Domain\Article;

use SiteApi\Domain\Article\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testShouldInstantiateArticleModel()
    {
        $model = new Article(
            'Article Title',
            'This is my very first post',
            'Shahrokh',
            ['PHP', 'NodeJS']
        );

        $this->assertEquals('Article Title', $model->getTitle());
        $this->assertEquals('This is my very first post', $model->getText());
        $this->assertEquals('Shahrokh', $model->getAuthor());
        $this->assertIsArray($model->getTags());
        $this->assertCount(2, $model->getTags());
    }
}
