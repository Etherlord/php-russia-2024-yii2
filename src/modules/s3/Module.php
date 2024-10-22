<?php

declare(strict_types=1);

namespace app\modules\s3;

use app\infrastructure\EnvType;
use app\modules\s3\storage\S3FileStorage;
use Aws\S3\S3Client;
use yii\base\InvalidConfigException;
use yii\base\Module as BaseModule;
use yii\console\Application as ConsoleApplication;
use yii\di\NotInstantiableException;

final class Module extends BaseModule
{
    /**
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        if (\Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'app\modules\s3\commands';
        }

        $container = \Yii::$container;

        $httpVerifyS3 = true;

        if (YII_ENV === 'dev') {
            $httpVerifyS3 = false;
        }

        $container->setSingleton(S3Client::class, params: [
            'args' => [
                'region' => env('S3_REGION', EnvType::ALPHABETIC_STRING, 'local'),
                'endpoint' => env('S3_ENDPOINT', EnvType::URL, 'http://minio-endpoint'),
                'use_path_style_endpoint' => true,
                'credentials' => [
                    'key' => env('S3_USER', EnvType::ALPHABETIC_STRING, 'user'),
                    'secret' => env('S3_PASSWORD', EnvType::ALPHABETIC_STRING, 'pass'),
                ],
                'http' => [
                    'verify' => $httpVerifyS3,
                ],
            ],
        ]);

        $container->setSingleton(S3FileStorage::class, params: [
            'client' => $container->get(S3Client::class),
        ]);

        $this->params['s3-bucket-name'] = env(
            'S3_BUCKET_NAME',
            EnvType::ALPHABETIC_STRING,
            'bucket-name',
        );
    }
}
