<?php
declare(strict_types = 1);

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SiteApi\Infrastructure\Pdo\PdoConnectionFactory;

/** \Slim\App $app */

include __DIR__ . '/articles.php';

$app->get('/', function (Request $request, Response $response, array $args) {
    $payload = json_encode(['hello' => 'world'], JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);

    /** @var PdoConnectionFactory $pdoConnection */
    $pdoConnection = $this->container->get(PdoConnectionFactory::class);
    $pdo = $pdoConnection->createConnectionBySource('website');

    return $response->withHeader('Content-Type', 'application/json');
});
