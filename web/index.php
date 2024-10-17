<?php

declare(strict_types=1);

use yii\web\Application;

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/env.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new Application($config))->run();
