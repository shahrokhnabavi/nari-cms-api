<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\Http;

use League\Container\Container;
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

    protected function setUp(): void
    {
        $this->request = $this->prophesize(ServerRequestInterface::class);
        $this->response = new Response(200);

        $container = $this->prophesize(Container::class);
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
}
