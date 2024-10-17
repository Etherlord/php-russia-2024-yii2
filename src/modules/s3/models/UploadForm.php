<?php

declare(strict_types=1);

namespace app\modules\s3\models;

use yii\base\Model;
use yii\web\UploadedFile;

final class UploadForm extends Model
{
    public function __construct(
        public UploadedFile $file,
        array $config = [],
    ) {
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false],
        ];
    }

    public function verify(): void
    {
        if (!$this->validate()) {
            throw new \RuntimeException(
                \sprintf(
                    'Upload validation errors: "%s"',
                    implode(',', $this->getErrors('file')),
                ),
            );
        }
    }
}
