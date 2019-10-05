<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\Pdo;

use InvalidArgumentException;
use PDO;
use PDOException;
use SiteApi\Infrastructure\Pdo\PdoConnectionFactory;
use PHPUnit\Framework\TestCase;
use SiteApi\Infrastructure\Pdo\PdoCredentials;
use SiteApi\Infrastructure\Pdo\PdoCredentialsManager;

class PdoConnectionFactoryTest extends TestCase
{
    public function testCreateConnectionBySource()
    {
        $pdqCredentials = new PdoCredentials('sqlite::memory:', 'username', 'password', '');

        $pdoCredentialsManager = $this->prophesize(PdoCredentialsManager::class);
        $pdoCredentialsManager->hasCredentials('shop')->willReturn(true);
        $pdoCredentialsManager->getCredentials('shop')->willReturn($pdqCredentials);

        $pdoConnectionFactory = new PdoConnectionFactory($pdoCredentialsManager->reveal());

        $pdo = $pdoConnectionFactory->createConnectionBySource('shop');

        $this->assertInstanceOf(PDO::class, $pdo);
    }

    public function testShouldSeeInvalidArgumentException()
    {
        $pdoCredentialsManager = $this->prophesize(PdoCredentialsManager::class);
        $pdoCredentialsManager->hasCredentials('wrongSource')->willReturn(false);

        $pdoConnectionFactory = new PdoConnectionFactory($pdoCredentialsManager->reveal());

        $this->expectException(InvalidArgumentException::class);
        $pdoConnectionFactory->createConnectionBySource('wrongSource');
    }

    public function testShouldSeePDOExceptionForWrongCredentials()
    {
        $pdqCredentials = new PdoCredentials('wrongDns', 'username', 'password', '');

        $pdoCredentialsManager = $this->prophesize(PdoCredentialsManager::class);
        $pdoCredentialsManager->hasCredentials('shop')->willReturn(true);
        $pdoCredentialsManager->getCredentials('shop')->willReturn($pdqCredentials);

        $pdoConnectionFactory = new PdoConnectionFactory($pdoCredentialsManager->reveal());

        $this->expectException(PDOException::class);
        $pdoConnectionFactory->createConnectionBySource('shop');
    }
}
