<?php
declare(strict_types = 1);

use SiteApi\Infrastructure\Http\ArticleController;

/** \Slim\App $app */

$app->get('/articles', ArticleController::class . ':list')
    ->setName('articles-list');

$app->get('/articles/{articleId:[a-f0-9-]{36}}', ArticleController::class . ':get')
    ->setName('article');

$app->post('/articles', ArticleController::class . ':create')
    ->setArgument('validationSchema', 'createArticle')
    ->setName('create-article');

$app->put('/articles/{articleId:[a-f0-9-]{36}}', ArticleController::class . ':edit')
    ->setArgument('validationSchema', 'editArticle')
    ->setName('edit-article');

$app->delete('/articles/{articleId:[a-f0-9-]{36}}', ArticleController::class . ':delete')
    ->setName('delete-article');

$app->post('/articles/{articleId:[a-f0-9-]{36}}/tag', ArticleController::class . ':addTagToArticle')
    ->setArgument('validationSchema', 'createTag')
    ->setName('add-tag-to-article');

$app->delete(
    '/articles/{articleId:[a-f0-9-]{36}}/tag/{tagId:[a-f0-9-]{36}}',
    ArticleController::class . ':removeTagFromArticle'
)->setName('add-tag-to-remove');
