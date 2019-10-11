<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\CommandBus;

use League\Container\Container;
use League\Tactician\Exception\MissingHandlerException;
use SiteApi\Infrastructure\CommandBus\ContainerLocator;
use PHPUnit\Framework\TestCase;

class ContainerLocatorTest extends TestCase
{
    /**
     * @var ContainerLocator
     */
    private $containerLocator;

    protected function setUp(): void
    {
        $container = new Container();
        $container->add('command-handler-id', function () {
            return 'command handler';
        });

        $this->containerLocator = new ContainerLocator($container, [
            'command-id-1' => 'command-handler-id'
        ]);
    }

    public function testShouldGetHandlerForCommandByPassingTheNameOfCommand()
    {
        $this->assertEquals(
            'command handler',
            $this->containerLocator->getHandlerForCommand('command-id-1')
        );
    }

    public function testShouldThrowMissingHandlerExceptionIfCanNotFindAnyHandlerForCommand()
    {
        $this->expectException(MissingHandlerException::class);

        $this->containerLocator->getHandlerForCommand('command-id-2');
    }
}
