<?php

declare(strict_types=1);

use yii\web\Application;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

defined('YII_DEBUG') || define('YII_DEBUG', env('YII_DEBUG'));
defined('YII_ENV') || define('YII_ENV', env('YII_ENV', default: 'dev'));

$config = require __DIR__ . '/../config/web.php';

(new Application($config))->run();
