<?php
declare(strict_types = 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use SiteApi\Infrastructure\ContainerFactory;
use Slim\App;

require __DIR__ . '/bootstrap.php';

$container = ContainerFactory::create();

$app = $container->get(App::class);

$app->get('/', function (Request $request, Response $response, array $args) {
    $payload = json_encode(['hello' => 'world'], JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
