<?php

use DI\Container;
use Module4Project\Repository\CategoryRepositoryFromPdo;
use Module4Project\Repository\PostRepositoryFromPdo;
use Module4Project\Repository\PostsCategoriesRepositoryFromPdo;

$container = new Container();

$container->set('settings', static function(){
    return [
        'db' => [
            'host' => $_ENV['DB_HOST'],
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'pass' => $_ENV['DB_PASS']
        ]
    ];
});

$container->set('db', static function ($c) {
    $db = $c->get('settings')['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
});

$container->set('post-repository', static function (Container $c){
    $pdo = $c->get('db');
    return new PostRepositoryFromPdo($pdo);
});

$container->set('category-repository', static function (Container $c){
    $pdo = $c->get('db');
    return new CategoryRepositoryFromPdo($pdo);
});

$container->set('posts_categories-repository', static function (Container $c){
    $pdo = $c->get('db');
    return new PostsCategoriesRepositoryFromPdo($pdo);
});

return $container;