<?php

declare(strict_types=1);

defined('YII_DEBUG') || define('YII_DEBUG', getenv('YII_DEBUG') ?: (bool) env('YII_DEBUG'));
defined('YII_ENV') || define('YII_ENV', getenv('YII_ENV') ?: env('YII_ENV', default: 'dev'));
