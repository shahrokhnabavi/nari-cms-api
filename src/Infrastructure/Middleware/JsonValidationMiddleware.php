<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Middleware;

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
    const SHCEMA_DIR = '/../../../schemas/';

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
        /** @var ResponseInterface $response */
        $response = $handler->handle($request);

        $method = $request->getMethod();
        if ($method === 'GET' || $method === 'DELETE') {
            return $response;
        }

        if (!$this->validateRequest($request)) {
            $this->logger->error(
                "Invalid {$method} request at: " .
                $request->getUri() .
                PHP_EOL .
                json_encode($this->validator->getErrors())
            );

            $response = new Response();
            $response->getBody()->write(json_encode($this->validator->getErrors()) ?: '');

            return $response->withStatus(400);
        }

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return bool
     */
    public function validateRequest(ServerRequestInterface $request): bool
    {
        /** @var Route $route */
        $route = $request->getAttribute('route');

        if (!$route instanceof Route) {
            throw new InvalidArgumentException('No route matches request at ' . $request->getUri());
        }

        $schemaName = $route->getArgument('validationSchema', '');

        if ($schemaName === '') {
            throw new InvalidArgumentException('no schema defined for ' . $request->getUri());
        }

        $schemaFile = __DIR__ . self::SHCEMA_DIR . $schemaName;

        if (!is_readable($schemaFile)) {
            throw new InvalidArgumentException('schema file for ' . $request->getUri() . ' is not available');
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
