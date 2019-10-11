<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\CommandBus;

use Monolog\Handler\TestHandler;
use Monolog\Logger;
use SiteApi\Application\Article\AddArticleCommand;
use SiteApi\Application\CommandBus\Command;
use SiteApi\Infrastructure\CommandBus\LoggingMiddleware;
use PHPUnit\Framework\TestCase;
use SiteApi\Infrastructure\ErrorHandling\ErrorHandlingFactory;

class LoggingMiddlewareTest extends TestCase
{
    /**
     * @var TestHandler
     */
    private $testLogHandler;

    /**
     * @var LoggingMiddleware
     */
    private $loggingMiddleware;

    protected function setUp(): void
    {
        $hdl = new TestHandler();
        $logger = new Logger('shah');
        $logger->pushHandler($hdl);

        $this->testLogHandler = $hdl;
        $this->loggingMiddleware = new LoggingMiddleware($logger);
    }

    public function testShouldSeeCommandMiddlewareWriteToLogHandler()
    {
        $command = new AddArticleCommand('','','','');
        $this->loggingMiddleware->execute($command, function ($command) {
            $this->assertInstanceOf(AddArticleCommand::class, $command);
        });

        $errorLogs = $this->testLogHandler->getRecords();
        $this->assertStringContainsString('Starting ' . AddArticleCommand::class, $errorLogs[0]['message']);
        $this->assertStringContainsString(AddArticleCommand::class . ' finished', $errorLogs[1]['message']);
    }
}
