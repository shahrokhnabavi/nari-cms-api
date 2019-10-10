<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\Http;

use League\Container\Container;
use League\Tactician\CommandBus;
use Psr\Http\Message\ResponseInterface;
use SiteApi\Infrastructure\Http\HttpController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Response;

class HttpControllerTest extends TestCase
{
    public function testShouldGetContainerFromHttpController()
    {
        $container = new Container();
        $container->add(CommandBus::class, function () {
            return new CommandBus([]);
        });
        $container->add('test', function (): array {
            return [
                'name' => 'shahrokh',
                'family' => 'nabavi',
            ];
        });

        $controller = new HttpController($container);
        $object = $controller->getContainerEntry('test');

        $this->assertEquals(['name' => 'shahrokh', 'family' => 'nabavi'], $object);
    }

    public function testShouldGetModifiedResponseFromHttpController()
    {
        $response = new Response(200);

        $container = $this->prophesize(Container::class);
        $container->get(CommandBus::class)->willReturn($this->prophesize(CommandBus::class)->reveal());

        $controller = new HttpController($this->prophesize(Container::class)->reveal());

        $newResponse = $controller->html($response, 'Hi tester');
        $newResponse->getBody()->rewind();

        $this->assertInstanceOf(ResponseInterface::class, $newResponse);
        $this->assertEquals('Hi tester', $newResponse->getBody()->getContents());
    }
}
