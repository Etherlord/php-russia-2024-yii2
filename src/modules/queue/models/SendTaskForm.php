<?php

declare(strict_types=1);

namespace app\modules\queue\models;

use yii\base\Model;

final class SendTaskForm extends Model
{
    public function __construct(
        public mixed $message,
        array $config = [],
    ) {
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['message', 'required'],
            ['message', function (string $attribute): void {
                if (!ctype_alnum((string) $this->{$attribute})) {
                    $this->addError($attribute, 'Message must contains only symbols and numbers');
                }
            }],
        ];
    }
}
