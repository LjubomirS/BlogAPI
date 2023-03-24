<?php

use Doctrine\DBAL\Types\Type;

require __DIR__ . '/vendor/autoload.php';

Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();