<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\Logging;

use Monolog\Logger;
use SiteApi\Infrastructure\Logging\LoggerFactory;
use PHPUnit\Framework\TestCase;

class LoggerFactoryTest extends TestCase
{
    private $fileName = '/../../../tmp/loggerFile';
    /**
     * @var LoggerFactory
     */
    private $logger;

    public function setup(): void
    {
        $this->logger = new LoggerFactory('test.environment');
    }

    protected function tearDown(): void
    {
        if (file_exists(__DIR__ . $this->fileName)) {
            unlink(__DIR__ . $this->fileName);
        }
    }

    public function testShouldCreateBasicFileLogger()
    {
        /** @var Logger $logger */
        $logger = $this->logger->createBasicFileLogger(__DIR__ . $this->fileName, 'info');

        $this->assertInstanceOf(Logger::class, $logger);
        $this->assertEquals('test.environment', $logger->getName());
        $this->assertCount(2, $logger->getHandlers());
        $this->assertCount(1, $logger->getProcessors());

        $logger->info('Test logger is THIS');
        $fileContent = file_get_contents(__DIR__ . $this->fileName);

        $this->assertStringContainsString('INFO: Test logger is THIS', $fileContent);
    }

    public function testShouldCreatePaperTrailAppLogger()
    {
        /** @var Logger $logger */
        $logger = $this->logger->createPaperTrailAppLogger(
            'logs6.papertrailapp.com',
            11752,
            'info'
        );

        $this->assertInstanceOf(Logger::class, $logger);
        $this->assertEquals('test.environment', $logger->getName());
        $this->assertCount(1, $logger->getHandlers());
        $this->assertCount(2, $logger->getProcessors());
    }
}
