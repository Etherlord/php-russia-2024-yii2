<?php

declare(strict_types=1);

namespace app\modules\s3\controllers;

use app\modules\s3\storage\S3FileStorage;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\di\NotInstantiableException;
use yii\web\Controller;
use yii\web\UploadedFile;

final class UploadController extends Controller
{
    private readonly S3FileStorage $fileStorage;

    private readonly string $bucketName;

    /**
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    public function __construct(
        string $id,
        Module $module,
        array $config = [],
    ) {
        parent::__construct($id, $module, $config);

        $this->fileStorage = \Yii::$container->get(S3FileStorage::class);
        $this->bucketName = \Yii::$app->getModule('s3')?->params['s3-bucket-name']
            ?? throw new \RuntimeException("Upload controller init failed. Can't get bucket name");
    }

    public function actionUpload(): array
    {
        $file = UploadedFile::getInstanceByName('file');

        if ($file === null) {
            \Yii::$app->response->setStatusCode(400);

            return [
                'errors' => "Can't upload file. File not found in request",
            ];
        }

        $filename = $file->getBaseName() . '.' . $file->getExtension();

        $this->fileStorage->upload(
            bucket: $this->bucketName,
            filename: $filename,
            fileContent: file_get_contents($file->tempName),
        );

        return [
            'url' => $this->fileStorage
                ->getPermanentDownloadUrl($this->bucketName, $filename)
                ?? 'file not found',
        ];
    }
}
