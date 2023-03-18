<?php

use Module4Project\Controller\HomeController;
use Slim\Factory\AppFactory;

use Module4Project\Controller\PostControllers\CreatePostController;
use Module4Project\Controller\PostControllers\DeletePostController;
use Module4Project\Controller\PostControllers\GetAllPostsController;
use Module4Project\Controller\PostControllers\ReadPostController;
use Module4Project\Controller\PostControllers\UpdatePostController;

use Module4Project\Controller\CategoryControllers\CreateCategoryController;
use Module4Project\Controller\CategoryControllers\DeleteCategoryController;
use Module4Project\Controller\CategoryControllers\GetAllCategoriesController;
use Module4Project\Controller\CategoryControllers\ReadCategoryController;
use Module4Project\Controller\CategoryControllers\UpdateCategoryController;

require __DIR__ . '/../boot.php';

$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->get('/',HomeController::class);

$app->post('/v1/posts/create',new CreatePostController($container));
$app->get('/v1/posts',new GetAllPostsController($container));
$app->get('/v1/posts/{slug}',new ReadPostController($container));
$app->put('/v1/posts/update/{slug}',new UpdatePostController($container));
$app->delete('/v1/posts/delete/{slug}',new DeletePostController($container));

$app->post('/v1/categories/create',new CreateCategoryController($container));
$app->get('/v1/categories',new GetAllCategoriesController($container));
$app->get('/v1/categories/{id}',new ReadCategoryController($container));
$app->put('/v1/categories/update/{id}',new UpdateCategoryController($container));
$app->delete('/v1/categories/delete/{id}',new DeleteCategoryController($container));

$app->addErrorMiddleware(true, true, true);

$app->run();