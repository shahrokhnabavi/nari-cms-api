<?php
declare(strict_types = 1);

namespace Tests\Helper;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class RequestHandlerMock implements RequestHandlerInterface
{
    /** @var ServerRequestInterface */
    private $processedRequest;

    /** @var Response */
    private $response;

    /**
     * @param Response|null $response
     */
    public function __construct(Response $response = null)
    {
        $this->response = $response;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->processedRequest = $request;
        return $this->response ?? new Response();
    }

    public function getProcessedRequest()
    {
        return $this->processedRequest;
    }
}
