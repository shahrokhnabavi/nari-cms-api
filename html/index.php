<?php
declare(strict_types = 1);

use SiteApi\Infrastructure\ContainerFactory;
use SiteApi\Infrastructure\Middleware\JsonBodyParserMiddleware;
use SiteApi\Infrastructure\Middleware\JsonValidationMiddleware;
use Slim\App;

require __DIR__ . '/../src/bootstrap.php';

$container = ContainerFactory::create();

$app = $container->get(App::class);

$app->add($container->get(JsonValidationMiddleware::class));
$app->add($container->get(JsonBodyParserMiddleware::class));

include __DIR__ . '/routes.php';

$app->addRoutingMiddleware();
$app->run();
