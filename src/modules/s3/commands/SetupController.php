<?php

declare(strict_types=1);

namespace app\modules\s3\commands;

use app\modules\s3\storage\S3FileStorage;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\di\NotInstantiableException;

final class SetupController extends Controller
{
    /**
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    public function actionSetup(): int
    {
        $fileStorage = \Yii::$container->get(S3FileStorage::class);
        $bucketName = \Yii::$app->getModule('s3')->params['s3-bucket-name']
            ?? throw new \RuntimeException("S3 setup failed. Can't get bucket name");

        \assert(\is_string($bucketName));
        if (!$fileStorage->isBucketExist($bucketName)) {
            $fileStorage->createBucket($bucketName);
        }

        return 0;
    }
}
