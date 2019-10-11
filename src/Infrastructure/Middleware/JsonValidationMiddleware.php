<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use InvalidArgumentException;
use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;
use Slim\Routing\Route;

class JsonValidationMiddleware
{
    /** @var string */
    const SHCEMA_DIR = APP_DIR . '/etc/schemas/';

    /** @var Validator */
    private $validator;

    /** @var LoggerInterface */
    private $logger;

    /**
     * @param Validator $validator
     * @param LoggerInterface $logger
     */
    public function __construct(Validator $validator, LoggerInterface $logger)
    {
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $method = $request->getMethod();
        if ($method === 'GET' || $method === 'DELETE') {
            return $handler->handle($request);
        }

        if (!$this->validateRequest($request)) {
            $this->logger->error(
                "Invalid {$method} request at: " .
                $request->getUri() .
                PHP_EOL .
                json_encode($this->validator->getErrors())
            );

            $response = new Response(StatusCodeInterface::STATUS_BAD_REQUEST);
            $response->getBody()->write(json_encode($this->validator->getErrors()) ?: '');

            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        return $handler->handle($request);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return bool
     */
    private function validateRequest(ServerRequestInterface $request): bool
    {
        /** @var Route $route */
        $route = $request->getAttribute('route');

        if (!$route instanceof Route) {
            throw new InvalidArgumentException('No route matches request at ' . $request->getUri());
        }

        $schemaName = $route->getArgument('validationSchema', '');

        if ($schemaName === '') {
            throw new InvalidArgumentException('No schema defined for ' . $request->getUri());
        }

        $schemaFile =  self::SHCEMA_DIR . $schemaName;

        if (!is_readable($schemaFile)) {
            throw new InvalidArgumentException('Schema file for ' . $request->getUri() . ' is not available');
        }

        $schema = json_decode(file_get_contents($schemaFile));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Unable to parse json file for ' . $request->getUri());
        }

        $dataToVerify = (array)$request->getParsedBody();
        $this->validator->validate(
            $dataToVerify,
            $schema,
            Constraint::CHECK_MODE_TYPE_CAST
        );

        return $this->validator->isValid();
    }
}
