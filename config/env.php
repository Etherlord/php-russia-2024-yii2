<?php

declare(strict_types=1);

use app\infrastructure\EnvType;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', '.env');
$dotenv->load();

defined('YII_DEBUG') || define('YII_DEBUG', env('YII_DEBUG', EnvType::BOOL, false));
defined('YII_ENV') || define('YII_ENV', env('YII_ENV', EnvType::ALPHABETIC_STRING, 'prod'));
