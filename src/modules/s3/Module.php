<?php

declare(strict_types=1);

namespace app\modules\s3;

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

        /** @psalm-suppress RiskyTruthyFalsyComparison */
        $container->setSingleton(S3Client::class, params: [
            'args' => [
                'region' => getenv('S3_REGION') ?: env('S3_REGION'),
                'endpoint' => getenv('S3_ENDPOINT') ?: env('S3_ENDPOINT'),
                'use_path_style_endpoint' => true,
                'credentials' => [
                    'key' => getenv('S3_USER') ?: env('S3_USER'),
                    'secret' => getenv('S3_PASSWORD') ?: env('S3_PASSWORD'),
                ],
                'http' => [
                    'verify' => $httpVerifyS3,
                ],
            ],
        ]);

        $container->setSingleton(S3FileStorage::class, params: [
            'client' => $container->get(S3Client::class),
        ]);

        /** @psalm-suppress RiskyTruthyFalsyComparison */
        $this->params['s3-bucket-name'] = getenv('S3_BUCKET_NAME') ?: env('S3_BUCKET_NAME');
    }
}
