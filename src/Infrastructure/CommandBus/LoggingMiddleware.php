<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\CommandBus;

use League\Tactician\Middleware;
use Psr\Log\LoggerInterface;

class LoggingMiddleware implements Middleware
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute($command, callable $next)
    {
        $commandClass = get_class($command);

        $this->logger->info("Starting $commandClass");
        $returnValue = $next($command);
        $this->logger->info("$commandClass finished without errors");

        return $returnValue;
    }
}
