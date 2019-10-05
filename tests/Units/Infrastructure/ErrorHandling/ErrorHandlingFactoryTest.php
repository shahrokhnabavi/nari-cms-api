<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\ErrorHandling;

use Monolog\Handler\TestHandler;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SiteApi\Infrastructure\ErrorHandling\ErrorHandlingFactory;
use PHPUnit\Framework\TestCase;
use Throwable;

class ErrorHandlingFactoryTest extends TestCase
{
    /** @var ErrorHandlingFactory */
    private $errorHandlingFactory;

    /** @var TestHandler */
    private $testHandler;

    protected function setUp(): void
    {
        $hdl = new TestHandler();
        $logger = new Logger('shah');
        $logger->pushHandler($hdl);

        $this->testHandler = $hdl;
        $this->errorHandlingFactory = new ErrorHandlingFactory($logger);
    }

    public function testShouldLogError()
    {
        \trigger_error('foo', E_USER_ERROR);

        $errorLogs = $this->testHandler->getRecords();
        $this->assertCount(1, $errorLogs);
        $this->assertEquals(400, $errorLogs[0]['level']);
        $this->assertEquals('ERROR', $errorLogs[0]['level_name']);
        $this->assertStringContainsString(E_USER_ERROR . ' - foo', $errorLogs[0]['message']);
    }

    public function testCreateBasicExceptionErrorHandler()
    {
        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getUri()->willReturn('localhost');

        $callableHandler = $this->errorHandlingFactory->createBasicExceptionErrorHandler();

        /** @var ResponseInterface $response */
        $response = $callableHandler(
            $request->reveal(),
            new \Exception('error', 200),
            false,
            false,
            false
        );

        $response->getBody()->seek(0);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals('Something went wrong!', $response->getBody()->getContents());
        $this->assertEquals('text/html', $response->getHeaderLine('Content-Type'));


        $errorLogs = $this->testHandler->getRecords();
        $this->assertStringContainsString('error', $errorLogs[0]['message']);
        $this->assertStringContainsString( 'localhost', $errorLogs[0]['context']['requestUri']);
    }

    public function testShouldLogException()
    {
        $exceptionHandler = set_exception_handler(null);

        $exceptionHandler(new \Exception('error', 200));

        $errorLogs = $this->testHandler->getRecords();
        $this->assertCount(1, $errorLogs);
        $this->assertEquals(400, $errorLogs[0]['level']);
        $this->assertEquals('ERROR', $errorLogs[0]['level_name']);
        $this->assertEquals(200, $errorLogs[0]['context']['errorCode']);
        $this->assertStringContainsString('error', $errorLogs[0]['message']);
    }
}
