<?php

declare(strict_types=1);

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
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning', 'info'],
            ],
        ],
    ],
    'queue' => [
        'class' => Queue::class,
        'as log' => LogBehavior::class,
        'path' => '@runtime/queue',
    ],
];
