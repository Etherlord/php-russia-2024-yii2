<?php

declare(strict_types=1);

namespace app\modules\welcome;

use app\infrastructure\EnvType;
use yii\base\Module as BaseModule;

final class Module extends BaseModule
{
    public function init(): void
    {
        parent::init();

        $this->params['welcome-message'] = env(
            'WELCOME_MESSAGE',
            EnvType::ALPHABETIC_STRING,
            'default welcome',
        );
    }
}
