<?php

declare(strict_types=1);

$bootstrap = require __DIR__ . '/bootstrap.php';
$commonComponents = require __DIR__ . '/common-components.php';
$modules = require __DIR__ . '/modules.php';

$config = [
    'id' => 'php-russia-2024-yii2-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => $bootstrap,
    'components' => $commonComponents,
    'modules' => $modules,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // requires version `2.1.21` of yii2-debug module
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
