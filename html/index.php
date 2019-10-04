<?php
declare(strict_types = 1);

use SiteApi\Infrastructure\ContainerFactory;
use Slim\App;

require __DIR__ . '/../etc/bootstrap.php';

$container = ContainerFactory::create();

$app = $container->get(App::class);

$app->run();
