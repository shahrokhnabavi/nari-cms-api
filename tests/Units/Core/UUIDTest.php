<?php
declare(strict_types = 1);

namespace Tests\Units\Core;

use Monolog\Test\TestCase;
use SiteApi\Core\InvalidIdentityException;
use SiteApi\Core\UUID;

class UUIDTest extends TestCase
{
    const TEST_UUID_1 = '123e4567-e89b-12d3-a456-426655440000';
    const TEST_UUID_2 = '123e4567-e89b-12d3-a456-426655441111';

    public function testCreateUuuidFromString()
    {
        $uuid = UUID::fromString(static::TEST_UUID_1);

        $this->assertInstanceOf(UUID::class, $uuid);
    }

    public function testThrowExceptionIfStringIsNotAValidUuid()
    {
        $this->expectException(InvalidIdentityException::class);

        UUID::fromString('invalid-string');
    }

    public function testShouldSeeTwoUuidAreEqual()
    {
        $uuid1 = UUID::fromString(static::TEST_UUID_1);
        $uuid2 = UUID::fromString(static::TEST_UUID_1);

        $this->assertTrue($uuid1->equals($uuid2));
    }

    public function testShouldSeeTwoUuidAreNotEqual()
    {
        $uuid1 = UUID::fromString(static::TEST_UUID_1);
        $uuid2 = UUID::fromString(static::TEST_UUID_2);

        $this->assertFalse($uuid1->equals($uuid2));
    }

    public function testShouldGenerateNewUuidIfThereIsNoIdentifierPresent()
    {
        $uuid = Uuid::create();

        $this->assertNotEquals('', (string)$uuid);
        $this->assertRegExp(UUID::PATTERN, (string)$uuid);
    }
}
