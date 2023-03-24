<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use DI\Container;

require_once __DIR__ . '/boot.php';

/** @var Container $container */
$container = require __DIR__ . '/config/container.php';

return ConsoleRunner::createHelperSet($container->get(EntityManager::class));