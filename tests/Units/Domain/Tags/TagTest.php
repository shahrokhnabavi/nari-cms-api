<?php
declare(strict_types = 1);

namespace Tests\Units\Domain\Tags;

use Exception;
use InvalidArgumentException;
use SiteApi\Core\UUID;
use SiteApi\Domain\Tags\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    /** @var string[] */
    private $tag = [
        'name' => 'NodeJS'
    ];

    /**
     * @throws Exception
     */
    public function testShouldCreateTagWithPredefinedUuidIdentifierClass()
    {
        $data = $this->tag;
        $data['identifier'] = UUID::create();

        $model = new Tag($data);

        $this->assertEquals($data['identifier'], (string)$model->getIdentifier());
    }

    /**
     * @throws Exception
     */
    public function testShouldThrowInvalidArgumentExceptionIfTagNameIsNotPresent()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name should not be empty');

        new Tag(['identifier' => 'a42c05c8-ec5c-11e9-81b4-2a2ae2dbcce4']);
    }

    /**
     * @throws Exception
     */
    public function testShouldThrowInvalidArgumentExceptionIfIdentifierIsNotPresent()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag identifier should not be empty');

        new Tag(['name' => 'some thing']);
    }
}
