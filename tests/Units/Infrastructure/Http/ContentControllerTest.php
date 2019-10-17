<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\Http;

use Exception;
use League\Container\Container;
use League\Tactician\CommandBus;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use SiteApi\Core\UUID;
use SiteApi\Domain\Article\Article;
use SiteApi\Domain\Article\Articles;
use SiteApi\Infrastructure\Article\PdoArticleRepository;
use SiteApi\Infrastructure\Http\ArticleController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Response;

class ArticleControllerTest extends TestCase
{
    /**
     * @var ArticleController
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

    /**
     * @var ObjectProphecy
     */
    private $pdoArticleRepository;

    protected function setUp(): void
    {
        $this->request = $this->prophesize(ServerRequestInterface::class);
        $this->request->getParsedBody()->willReturn([]);

        $this->response = new Response(200);

        $this->commandBus = $this->prophesize(CommandBus::class);
        $this->commandBus->handle(Argument::any())->willReturn(null);

        $this->pdoArticleRepository = $this->prophesize(PdoArticleRepository::class);

        $container = $this->prophesize(Container::class);
        $container->get(CommandBus::class)->willReturn($this->commandBus->reveal());
        $container->get(PdoArticleRepository::class)->willReturn($this->pdoArticleRepository->reveal());

        $this->controller = new ArticleController($container->reveal());
    }

    public function testList()
    {
        $this->pdoArticleRepository->getList()->willReturn(new Articles([
            [
                'identifier' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002',
                'title' => 'My Article',
                'text' => 'In this article we try to read a lot about technology one',
                'author' => 'admin',
                'tagId' => null,
                'tagName' => null,
            ],
            [
                'identifier' => 'fa98354e-ec5c-11e9-81b4-2a2ae2dbcce4',
                'title' => 'My First Blog',
                'text' => 'In this post we are going to explain how to win.',
                'author' => 'shahrokh',
                'tagId' => '4f5bc1d2-ec5c-11e9-81b4-2a2ae2dbcce4',
                'tagName' => 'php',
            ],
            [
                'identifier' => 'fa98354e-ec5c-11e9-81b4-2a2ae2dbcce4',
                'title' => 'My First Blog',
                'text' => 'In this post we are going to explain how to win.',
                'author' => 'shahrokh',
                'tagId' => 'a42c05c8-ec5c-11e9-81b4-2a2ae2dbcce4',
                'tagName' => 'nodejs',
            ]
        ]));


        $response = $this->controller->list($this->request->reveal(), $this->response, []);
        $response->getBody()->rewind();

        $data = [
            'ba9b9898-ed95-11e9-aa8f-0242c0a8f002' => [
                'title' => 'My Article',
                'text' => 'In this article we try to read a lot about technology one',
                'author' => 'admin',
                'tags' => []
            ],
            'fa98354e-ec5c-11e9-81b4-2a2ae2dbcce4' => [
                'title' => 'My First Blog',
                'text' => 'In this post we are going to explain how to win.',
                'author' => 'shahrokh',
                'tags' => [
                    '4f5bc1d2-ec5c-11e9-81b4-2a2ae2dbcce4' => 'php',
                    'a42c05c8-ec5c-11e9-81b4-2a2ae2dbcce4' => 'nodejs'
                ]
            ]
        ];

        $this->assertJsonStringEqualsJsonString(
            json_encode($data),
            $response->getBody()->getContents()
        );
    }

    public function testGet()
    {
        $articleId = UUID::fromString('ba9b9898-ed95-11e9-aa8f-0242c0a8f002');
        $this->pdoArticleRepository->getArticleById(Argument::any())->willReturn(
            new Article(['identifier' => $articleId, 'title' => 'Article'])
        );

        $response = $this->controller->get(
            $this->request->reveal(),
            $this->response,
            ['articleId' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002']
        );
        $response->getBody()->rewind();

        $this->assertJsonStringEqualsJsonString(
            json_encode(['identifier' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002', 'title' => 'Article', 'text' => '', 'author' => '', 'tags' => []]),
            $response->getBody()->getContents()
        );
    }

    public function testDelete()
    {
        $response = $this->controller->delete(
            $this->request->reveal(),
            $this->response,
            ['articleId' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002']
        );

        $this->assertEquals(202, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testAddTagToArticle()
    {
        $this->request->getParsedBody()->willReturn(['name' => 'javascript']);

        $response = $this->controller->addTagToArticle(
            $this->request->reveal(),
            $this->response,
            ['articleId' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002']
        );

        $this->assertEquals(202, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testRemoveTagToArticle()
    {
        $response = $this->controller->removeTagFromArticle(
            $this->request->reveal(),
            $this->response,
            [
                'articleId' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002',
                'tagId' => '43cd9898-ed95-11e9-aa8f-0242c0a8f00a'
            ]
        );

        $this->assertEquals(202, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testEdit()
    {
        $this->request->getParsedBody()->willReturn(['title' => 'Update']);

        $response = $this->controller->edit(
            $this->request->reveal(),
            $this->response,
            ['articleId' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002']
        );
        $response->getBody()->rewind();

        $this->assertJsonStringEqualsJsonString(
            json_encode(['status' => 'success','identifier' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002']),
            $response->getBody()->getContents()
        );
    }

    public function testShouldSeeStatusCode200AndCorrectResponseFromCreateEndPoint()
    {
        $this->request->getParsedBody()->willReturn(['title' => '']);

        $response = $this->controller->create($this->request->reveal(), $this->response, []);
        $response->getBody()->rewind();
        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(2, $data);
        $this->assertEquals('success', $data['status']);
        $this->assertArrayHasKey('identifier', $data);
    }

    /**
     * @dataProvider getActions
     */
    public function testShouldSeeStatusCode400AndErrorMessageIfSomethingWentWrongFromCreateEndPoint($action)
    {
        $this->request->getParsedBody()->willReturn(['title' => '', 'name' => '']);
        $this->commandBus->handle(Argument::any())->willThrow(new Exception('Something went wrong'));

        switch($action) {
            case 'create':
                $response = $this->controller->create($this->request->reveal(), $this->response, []);
                break;
            case 'edit':
                $response = $this->controller->edit(
                    $this->request->reveal(),
                    $this->response,
                    ['articleId' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002']
                );
                break;
            case 'delete':
                $response = $this->controller->delete(
                    $this->request->reveal(),
                    $this->response,
                    ['articleId' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002']
                );
                break;
            case 'addTagToArticle':
                $response = $this->controller->addTagToArticle(
                    $this->request->reveal(),
                    $this->response,
                    ['articleId' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002']
                );
                break;
            case 'removeTagFromArticle':
                $response = $this->controller->removeTagFromArticle(
                    $this->request->reveal(),
                    $this->response,
                    [
                        'articleId' => 'ba9b9898-ed95-11e9-aa8f-0242c0a8f002',
                        'tagId' => '43cd9898-ed95-11e9-aa8f-0242c0a8f00a'
                    ]
                );
                break;
        }
        $response->getBody()->rewind();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertStringContainsString('Something went wrong', $response->getBody()->getContents());
    }

    public function getActions()
    {
        return [
            ['create'],
            ['edit'],
            ['delete'],
            ['addTagToArticle'],
            ['removeTagFromArticle'],
        ];
    }
}
