<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;

class CorsMiddleware
{
    /** @var string[] */
    const ALLOWED_ORIGINS = [
        '0.0.0.0',
        'localhost'
    ];

    /** @var string[] */
    const DEFAULT_EXPOSED_HEADERS = [
        'cache-control',
        'content-language',
        'content-type',
        'expires',
        'last-modified',
        'pragma',
    ];

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var ResponseInterface $response */
        $response = $handler->handle($request);

        $exposeHeaders = array_filter(
            array_keys($response->getHeaders()),
            function (string $header): bool {
                return !in_array(strtolower($header), self::DEFAULT_EXPOSED_HEADERS);
            }
        );

        if (!empty($exposeHeaders)) {
            $response = $response->withHeader('Access-Control-Expose-Headers', implode(',', $exposeHeaders));
        }

        if ($this->isAllowedOrigin($request)) {
            $response = $response->withHeader('Access-Control-Allow-Origin', $this->getOrigin($request));
        }

        return $this->addAllowedHeadersToResponse($request, $response)
            ->withHeader(
                'Access-Control-Allow-Methods',
                'GET, POST, DELETE, PATCH, PUT, HEAD, CONNECT, OPTIONS, TRACE'
            );
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    private function getOrigin(ServerRequestInterface $request): string
    {
        if (!$request->hasHeader('Origin')) {
            return '';
        }

        return $request->getHeaderLine('Origin');
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return bool
     */
    private function isAllowedOrigin(ServerRequestInterface $request): bool
    {
        $hosts = implode('|', array_map('preg_quote', self::ALLOWED_ORIGINS));
        return preg_match('/https?\:\/\/(?:' . $hosts . ')(?:\:\d+)?$/', $this->getOrigin($request)) === 1;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    private function addAllowedHeadersToResponse(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $allowedHeaders = array_map(function (string $header): string {
            return strtolower(str_replace('_', '-', $header));
        }, array_keys($request->getHeaders()));

        $allowedHeaders[] = 'x-requested-with';

        return $response->withHeader('Access-Control-Allow-Headers', implode(',', $allowedHeaders));
    }
}
