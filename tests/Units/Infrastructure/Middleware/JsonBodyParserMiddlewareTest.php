<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\Middleware;

use SiteApi\Infrastructure\Middleware\JsonBodyParserMiddleware;
use PHPUnit\Framework\TestCase;
use Slim\MiddlewareDispatcher;
use Slim\Psr7\Environment;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Psr7\Stream;
use Slim\Psr7\Uri;
use Tests\Helper\RequestHandlerMock;

class JsonBodyParserMiddlewareTest extends TestCase
{
    /** @var string */
    const INPUT_STREAM_FILE = __DIR__ . '/../../../data/inputStreamFile';
    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /** @var JsonBodyParserMiddleware */
    private $middleware;

    public function setUp(): void
    {
        $this->response = new Response(
            200,
            null,
            new Stream(fopen("php://temp", 'r+'))
        );
        $this->response->getBody()->write("Welcome");

        $this->request = new Request(
            'GET',
            new Uri('https', 'example.com', 433, '/foo/bar'),
            new Headers(),
            [],
            Environment::mock(),
            new Stream(fopen('php://temp', 'r+'))
        );

        $this->middleware = new JsonBodyParserMiddleware(self::INPUT_STREAM_FILE);
    }

    public function testShouldNotInjectParsedJsonDataToRequest()
    {
        $mwMock = new RequestHandlerMock();

        $this->middleware->process($this->request, new MiddlewareDispatcher($mwMock));

        $this->assertNull($mwMock->getProcessedRequest()->getParsedBody());
    }

    public function testShouldInjectParsedJsonDataToRequestIfContentTypeIsJson()
    {
        $data = file_get_contents(self::INPUT_STREAM_FILE);

        $mwMock = new RequestHandlerMock();

        $this->middleware->process(
            $this->request->withHeader('Content-Type', 'application/json'),
            new MiddlewareDispatcher($mwMock)
        );

        $this->assertEquals(json_decode($data, true), $mwMock->getProcessedRequest()->getParsedBody());
    }

    public function testShouldSeeWelcomeTextInResponseContent()
    {
        $mwMock = new RequestHandlerMock($this->response);

        $response = $this->middleware->process($this->request, new MiddlewareDispatcher($mwMock));

        $response->getBody()->rewind();
        $this->assertEquals('Welcome', $response->getBody()->getContents());
    }
}

