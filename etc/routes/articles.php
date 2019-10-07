<?php
declare(strict_types = 1);

use SiteApi\Infrastructure\Http\ContentController;

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
