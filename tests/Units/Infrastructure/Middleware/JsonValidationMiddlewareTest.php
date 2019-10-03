<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\Middleware;

use InvalidArgumentException;
use JsonSchema\Validator;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use SiteApi\Infrastructure\Middleware\JsonValidationMiddleware;
use Slim\Psr7\Response;
use Slim\Routing\Route;

class JsonValidationMiddlewareTest extends TestCase
{
    private $uri = 'http://localhost.dev/contents';

    private $route;

    private $requestBody = [
        'name' => 'tester',
        'age' => 35,
        'height' => 1.7,
        'skills' => ["PHP", "Javascript"],
    ];

    /**
     * @var JsonValidationMiddleware
     */
    private $jsonValidationMW;

    protected function setUp(): void
    {
        if (!defined('APP_DIR')) {
            define('APP_DIR', __DIR__ . '/../../../..');
        }
        $this->route = $this->prophesize(Route::class);

        /** @var LoggerInterface $logger */
        $logger = $this->prophesize(LoggerInterface::class)->reveal();

        $this->jsonValidationMW = new JsonValidationMiddleware(new Validator(), $logger);
    }

    public function testShouldReturnStatusCode200IfRequestBodyIsValid()
    {
        list($response, $request) = $this->generateRequirments([
            'schema' => '../../tests/data/schemas/unitTestSchema.json',
        ]);

        $newResponse = $this->jsonValidationMW->__invoke($request->reveal(), $response->reveal());

        $this->assertEquals(200, $newResponse->getStatusCode());
    }

    public function testShouldReturnStatusCode400IfRequestBodyIsNotValid()
    {
        $requestBody = $this->requestBody;
        $requestBody['height'] = 'Invalid Value';

        list($response, $request) = $this->generateRequirments([
            'schema' => '../../tests/data/schemas/unitTestSchema.json',
            'requestBody' => $requestBody,
        ]);

        $newResponse = $this->jsonValidationMW->__invoke($request->reveal(), $response->reveal());

        $this->assertEquals(400, $newResponse->getStatusCode());
    }

    public function testShouldReturnStatusCode200IfRequestMethodIsGet()
    {
        list($response, $request) = $this->generateRequirments(['requestMethod' => 'GET']);

        $newResponse = $this->jsonValidationMW->__invoke($request->reveal(), $response->reveal());

        $this->assertEquals(200, $newResponse->getStatusCode());
    }

    public function testShouldThrowAnInvalidArgumentExceptionIfRouteIsNotMatch()
    {
        list($response, $request) = $this->generateRequirments([
            'route' => null
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("No route matches request at {$this->uri}");

        $this->jsonValidationMW->__invoke($request->reveal(), $response->reveal());
    }

    public function testShouldThrowAnInvalidArgumentExceptionIfNoSchemaIsDefined()
    {
        list($response, $request) = $this->generateRequirments([
            'schema' => '',
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("No schema defined for {$this->uri}");

        $this->jsonValidationMW->__invoke($request->reveal(), $response->reveal());
    }

    public function testShouldThrowAnInvalidArgumentExceptionIfSchemaFileIsNotAvailable()
    {
        list($response, $request) = $this->generateRequirments([
            'schema' => 'unitTestSchema.json',
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Schema file for {$this->uri} is not available");

        $this->jsonValidationMW->__invoke($request->reveal(), $response->reveal());
    }

    public function testShouldThrowAnInvalidArgumentExceptionIfSchemaIsNotAValidJson()
    {
        list($response, $request) = $this->generateRequirments([
            'schema' => '../../tests/data/schemas/unitTestSchemaInvalid.json'
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Unable to parse json file for {$this->uri}");

        $this->jsonValidationMW->__invoke($request->reveal(), $response->reveal());
    }

    private function generateRequirments(array $with)
    {
        if (isset($with['schema'])) {
            $this->route->getArgument('validationSchema', '')->willReturn($with['schema']);
        }

        $response = $this->prophesize(RequestHandlerInterface::class);

        $response->handle(Argument::cetera())->willReturn(
            key_exists('response', $with) ? $with['response'] : new Response(200)
        );

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getMethod()->willReturn($with['requestMethod'] ?? 'POST');
        $request->getUri()->willReturn($with['uri'] ?? $this->uri);

        $request->getAttribute('route')->willReturn(
            key_exists('route', $with) ? $with['route'] : $this->route->reveal()
        );

        $request->getParsedBody()->willReturn(
            key_exists('requestBody', $with) ? $with['requestBody'] : $this->requestBody
        );

        return [
            $response,
            $request,
        ];
    }
}
