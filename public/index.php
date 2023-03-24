<?php

use Module5Project\Middleware\JwtGenerator;
use Slim\Factory\AppFactory;

use Module5Project\Controller\HomeController;

use Module5Project\Controller\PostControllers\CreatePostController;
use Module5Project\Controller\PostControllers\DeletePostController;
use Module5Project\Controller\PostControllers\GetAllPostsController;
use Module5Project\Controller\PostControllers\ReadPostController;
use Module5Project\Controller\PostControllers\UpdatePostController;

use Module5Project\Controller\CategoryControllers\CreateCategoryController;
use Module5Project\Controller\CategoryControllers\DeleteCategoryController;
use Module5Project\Controller\CategoryControllers\GetAllCategoriesController;
use Module5Project\Controller\CategoryControllers\ReadCategoryController;
use Module5Project\Controller\CategoryControllers\UpdateCategoryController;

require __DIR__ . '/../boot.php';

$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$token = JwtGenerator::generateToken();

$app->get('/',HomeController::class);

$app->post('/v1/posts/create',new CreatePostController($container))->add($token);
$app->get('/v1/posts',new GetAllPostsController($container));
$app->get('/v1/posts/{id}',new ReadPostController($container));
$app->put('/v1/posts/update/{id}',new UpdatePostController($container))->add($token);
$app->delete('/v1/posts/delete/{id}',new DeletePostController($container))->add($token);

$app->post('/v1/categories/create',new CreateCategoryController($container))->add($token);
$app->get('/v1/categories',new GetAllCategoriesController($container));
$app->get('/v1/categories/{id}',new ReadCategoryController($container));
$app->put('/v1/categories/update/{id}',new UpdateCategoryController($container))->add($token);
$app->delete('/v1/categories/delete/{id}',new DeleteCategoryController($container))->add($token);

$app->addErrorMiddleware(true, true, true);

$app->run();