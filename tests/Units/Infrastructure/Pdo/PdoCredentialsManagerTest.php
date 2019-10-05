<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\Pdo;

use SiteApi\Infrastructure\Pdo\PdoCredentialException;
use SiteApi\Infrastructure\Pdo\PdoCredentials;
use SiteApi\Infrastructure\Pdo\PdoCredentialsManager;
use PHPUnit\Framework\TestCase;

class PdoCredentialsManagerTest extends TestCase
{
    /**
     * @var PdoCredentialsManager
     */
    private $manager;

    /**
     * @var \Prophecy\Prophecy\ObjectProphecy
     */
    private $credentials;

    protected function setUp(): void
    {
        $this->credentials = $this->prophesize(PdoCredentials::class);
        $this->credentials->getDns()->willReturn('Test DNS');

        $this->manager = new PdoCredentialsManager();
    }

    public function testShouldSeeNewCredentialsIsAddedToCredentialsManager()
    {
        $this->assertFalse($this->manager->hasCredentials('shop'));

        $this->manager->addCredentials(
            'shop',
            $this->credentials->reveal()
        );

        $this->assertTrue($this->manager->hasCredentials('shop'));
    }

    public function testShouldThrowPdoCredentialExceptionIfCredentialsAlreadyExistsInCredentialsManager()
    {
        $this->manager->addCredentials('shop', $this->credentials->reveal());

        $this->expectException(PdoCredentialException::class);
        $this->expectExceptionMessage("The key 'shop' already exists in the credential store.");

        $this->manager->addCredentials('shop', $this->credentials->reveal());
    }

    public function testShouldGetCredentialsFromCredentialsManager()
    {
        $credential = $this->credentials->reveal();
        $this->manager->addCredentials('shop', $credential);

        $storedCredential = $this->manager->getCredentials('shop');

        $this->assertEquals('Test DNS', $storedCredential->getDns());
    }

    public function testShouldThrowPdoCredentialExceptionIfCredentialsDoesNotExistsInCredentialsManager()
    {
        $this->expectException(PdoCredentialException::class);
        $this->expectExceptionMessage("The key 'shop' doesn't exist in the credential store.");

        $this->manager->getCredentials('shop');
    }
}
