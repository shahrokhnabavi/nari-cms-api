<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\ErrorHandling;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;
use Throwable;

class ErrorHandlingFactory
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

        set_error_handler($this->createPHPErrorHandler());
        set_exception_handler($this->createPHPExceptionHandler());
    }

    /**
     * @return callable
     */
    public function createBasicExceptionErrorHandler(): callable
    {
        return function (
            ServerRequestInterface $request,
            Throwable $exception
        ): ResponseInterface {
            $errorDetails = [
                'errorCode' => $exception->getCode(),
                'error' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'requestUri' => (string)$request->getUri(),
                'exception' => $exception
            ];

            $this->logger->error($exception->getMessage(), $errorDetails);

            $response = new Response(500);
            $response->getBody()->write('Something went wrong!');

            return $response->withHeader('Content-Type', 'text/html');
        };
    }


    /**
     * @return callable
     */
    private function createPHPErrorHandler(): callable
    {
        return function (int $errorNumber, string $error, string $file, int $line): bool {
            if (!(error_reporting() & $errorNumber)) {
                return false;
            }

            $errorDetails = [
                'errorNumber' => $errorNumber,
                'error' => $error,
                'file' => $file . ':' . $line,
            ];
            $this->logger->error(implode(' - ', $errorDetails));
            return true;
        };
    }

    /**
     * @return callable
     */
    private function createPHPExceptionHandler(): callable
    {
        return function (Throwable $exception): void {
            $errorDetails = [
                'errorCode' => $exception->getCode(),
                'error' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'exception' => $exception
            ];

            $this->logger->error($exception->getMessage(), $errorDetails);
        };
    }
}
