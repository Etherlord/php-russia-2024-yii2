<?php

declare(strict_types=1);

use Sil\JsonLog\target\JsonFileTarget;
use yii\queue\file\Queue;
use yii\queue\LogBehavior;

return [
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => JsonFileTarget::class,
                'levels' => ['error', 'warning', 'info'],
                'logFile' => 'php://stdout',
                'logVars' => [],
            ],
        ],
    ],
    'queue' => [
        'class' => Queue::class,
        'as log' => LogBehavior::class,
        'path' => '@runtime/queue',
    ],
];
