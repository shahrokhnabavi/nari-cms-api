<?php
declare(strict_types = 1);

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SiteApi\Infrastructure\Http\ContentController;
use SiteApi\Infrastructure\Pdo\PdoConnectionFactory;

/** \Slim\App $app */

$app->get('/contents', ContentController::class . ':list')
    ->setName('contents-list');
$app->get('/contents/{contentId:[a-f0-9]+}', ContentController::class . ':get')
    ->setName('content');
$app->post('/contents', ContentController::class . ':create')
    ->setArgument('validationSchema', 'createContent')
    ->setName('create-content');
$app->put('/contents/{contentId:[a-f0-9]+}', ContentController::class . ':edit')
    ->setArgument('validatioSchema', 'editContent')
    ->setName('edit-content');
$app->delete('/contents/{contentId:[a-f0-9]+}', ContentController::class . ':delete')
    ->setName('delete-content');

$app->get('/', function (Request $request, Response $response, array $args) {
    $payload = json_encode(['hello' => 'world'], JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);

    /** @var PdoConnectionFactory $pdoConnection */
    $pdoConnection = $this->container->get(PdoConnectionFactory::class);
    $pdo = $pdoConnection->createConnectionBySource('website');

    return $response->withHeader('Content-Type', 'application/json');
});
