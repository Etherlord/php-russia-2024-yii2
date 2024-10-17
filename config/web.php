<?php

declare(strict_types=1);
use app\modules\index\Module;

$config = [
    'id' => 'php-russia-2024-yii2',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'index/index/error',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'GET /' => 'index/index',
                'GET /api/v1/welcome' => 'welcome/welcome/welcome',
            ],
        ],
    ],
    'modules' => [
        'index' => ['class' => Module::class],
        'welcome' => ['class' => app\modules\welcome\Module::class],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
