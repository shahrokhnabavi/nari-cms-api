<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\Http;

use Exception;
use League\Container\Container;
use League\Tactician\CommandBus;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use SiteApi\Infrastructure\Http\ContentController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Response;

class ContentControllerTest extends TestCase
{
    /**
     * @var ContentController
     */
    private $controller;

    /**
     * @var ObjectProphecy
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var CommandBus
     */
    private $commandBus;

    protected function setUp(): void
    {
        $this->request = $this->prophesize(ServerRequestInterface::class);
        $this->request->getParsedBody()->willReturn([]);

        $this->response = new Response(200);

        $this->commandBus = $this->prophesize(CommandBus::class);
        $this->commandBus->handle(Argument::any())->willReturn(null);

        $container = $this->prophesize(Container::class);
        $container->get(CommandBus::class)->willReturn($this->commandBus->reveal());

        $this->controller = new ContentController($container->reveal());
    }

    public function testList()
    {
        $response = $this->controller->list($this->request->reveal(), $this->response, []);
        $response->getBody()->rewind();

        $this->assertEquals('List', $response->getBody()->getContents());
    }

    public function testGet()
    {
        $response = $this->controller->get($this->request->reveal(), $this->response, []);
        $response->getBody()->rewind();

        $this->assertEquals('get', $response->getBody()->getContents());
    }

    public function testDelete()
    {
        $response = $this->controller->delete($this->request->reveal(), $this->response, []);
        $response->getBody()->rewind();

        $this->assertEquals('delete', $response->getBody()->getContents());
    }

    public function testEdit()
    {
        $response = $this->controller->edit($this->request->reveal(), $this->response, []);
        $response->getBody()->rewind();

        $this->assertEquals('edit', $response->getBody()->getContents());
    }

    public function testShouldSeeStatusCode200AndCorrectResponseFromCreateEndPoint()
    {
        $this->request->getParsedBody()->willReturn(['title' => '']);

        $response = $this->controller->create($this->request->reveal(), $this->response, []);
        $response->getBody()->rewind();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('create', $response->getBody()->getContents());
    }

    public function testShouldSeeStatusCode400AndErrorMessageIfSomethingWentWrongFromCreateEndPoint()
    {
        $this->request->getParsedBody()->willReturn(['title' => '']);
        $this->commandBus->handle(Argument::any())->willThrow(new Exception('Something went wrong'));

        $response = $this->controller->create($this->request->reveal(), $this->response, []);
        $response->getBody()->rewind();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertStringContainsString('Something went wrong', $response->getBody()->getContents());
    }
}
