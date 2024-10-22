<?php

declare(strict_types=1);

$bootstrap = require __DIR__ . '/bootstrap.php';
$commonComponents = require __DIR__ . '/common-components.php';
$modules = require __DIR__ . '/modules.php';

$config = [
    'id' => 'php-russia-2024-yii2',
    'basePath' => dirname(__DIR__),
    'bootstrap' => $bootstrap,
    'components' => [
        ...$commonComponents,
        ...[
            'request' => [
                'enableCookieValidation' => false,
            ],
            'errorHandler' => [
                'errorAction' => 'index/index/error',
            ],
            'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                    'GET /' => 'index/index',
                    'GET /api/v1/welcome' => 'welcome/welcome/welcome',
                    'POST /api/v1/upload-file' => 's3/upload/upload',
                ],
            ],
        ],
    ],
    'modules' => $modules,
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
