<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Logging;

use Exception;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;
use Psr\Log\LoggerInterface;
use Vube\Monolog\Formatter\SplunkLineFormatter;

class LoggerFactory
{
    /** @var string */
    private $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $filePath
     * @param string $logLevel
     *
     * @return LoggerInterface
     * @throws Exception
     */
    public function createBasicFileLogger(string $filePath, string $logLevel): LoggerInterface
    {
        $logger = new Logger($this->name);

        $formatter = new LineFormatter(
            str_replace('%channel%.', '', LineFormatter::SIMPLE_FORMAT),
            null,
            false,
            true
        );

        $fileHandler = new StreamHandler($filePath, 1);
        $fileHandler->setFormatter($formatter);

        $consoleHandler = new StreamHandler('php://stdout', $this->determineLogLevel($logLevel));
        $consoleHandler->setFormatter($formatter);

        $logger->pushHandler($fileHandler);
        $logger->pushHandler($consoleHandler);
        $logger->pushProcessor(new LogMessageTagProcessor());

        return $logger;
    }

    /**
     * @see https://papertrailapp.com/
     * @param string $hostname
     * @param int $port
     * @param string $logLevel
     *
     * @return LoggerInterface
     */
    public function createPaperTrailAppLogger(string $hostname, int $port, string $logLevel): LoggerInterface
    {
        $logger = new Logger($this->name);

        $formatter = new LineFormatter('%channel%.%level_name%: %message% %extra%');

        $handler = new SyslogUdpHandler(
            $hostname,
            $port,
            LOG_USER,
            $this->determineLogLevel($logLevel)
        );
        $handler->setFormatter($formatter);

        $logger->pushHandler($handler);
        $logger->pushProcessor(new WebProcessor());
        $logger->pushProcessor(new LogMessageTagProcessor());

        return $logger;
    }

    /**
     * @param string $level
     *
     * @return int
     */
    private function determineLogLevel(string $level): int
    {
        $levels = Logger::getLevels();
        $levelsKey = strtoupper($level);

        return $levels[$levelsKey] ?? Logger::WARNING;
    }
}
