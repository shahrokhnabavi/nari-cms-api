<?php
declare(strict_types = 1);

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/** \Slim\App $app */

include __DIR__ . '/articles.php';

$app->get('/', function (Request $request, Response $response, array $args) {
    $payload = json_encode(['hello' => 'world'], JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
});
