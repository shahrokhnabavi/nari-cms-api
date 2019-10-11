<?php
declare(strict_types = 1);

namespace Tests\Units\Domain\Tags;

use SiteApi\Domain\Tags\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function testShouldInstantiateTagModel()
    {
        $model = new Tag(
            'Tag Name'
        );

        $this->assertEquals('Tag Name', $model->getName());
    }
}
