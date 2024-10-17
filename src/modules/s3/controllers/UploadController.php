<?php

declare(strict_types=1);

namespace app\modules\s3\controllers;

use app\modules\s3\models\UploadForm;
use app\modules\s3\storage\S3FileStorage;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\di\NotInstantiableException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

final class UploadController extends Controller
{
    public $enableCsrfValidation = false;

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

    public function beforeAction($action): bool
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public function actionUpload(): string
    {
        $file = UploadedFile::getInstanceByName('file')
            ?? throw new \RuntimeException("Can't upload file. File not found in request");
        $uploadForm = new UploadForm($file);
        $uploadForm->verify();

        $filename = $uploadForm->file->getBaseName() . '.' . $uploadForm->file->getExtension();

        $this->fileStorage->upload(
            bucket: $this->bucketName,
            filename: $filename,
            fileContent: file_get_contents($uploadForm->file->tempName),
        );

        return json_encode([
            'url' => $this->fileStorage
                ->getPermanentDownloadUrl($this->bucketName, $filename)
                ?? 'file not found',
        ], JSON_THROW_ON_ERROR);
    }
}
