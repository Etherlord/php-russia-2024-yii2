<?php

declare(strict_types=1);

use agielks\yii2\jwt\Jwt;
use app\infrastructure\EnvType;
use app\infrastructure\models\User;
use yii\web\JsonResponseFormatter;
use yii\web\Response;

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
            'jwt' => [
                'class' => Jwt::class,
                'signer' => 'HS256',
                'key'   => env('JWT_SECRET', EnvType::ALPHABETIC_STRING, 'secret'),
            ],
            'user' => [
                'identityClass' => User::class,
                'enableAutoLogin' => false,
                'enableSession' => false,
            ],
            'request' => [
                'enableCsrfValidation' => false,
                'enableCsrfCookie' => false,
                'enableCookieValidation' => false,
                'parsers' => [
                    'application/json' => 'yii\web\JsonParser',
                ],
            ],
            'response' => [
                'format' => Response::FORMAT_JSON,
                'formatters' => [
                    Response::FORMAT_JSON => [
                        'class' => JsonResponseFormatter::class,
                        'prettyPrint' => false,
                        'encodeOptions' => JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE,
                    ],
                ],
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
                    'POST /api/v1/send-task-to-consumer' => 'queue/send/send-task',
                    'POST /api/v1/authenticate' => 'auth/auth/authenticate',
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
