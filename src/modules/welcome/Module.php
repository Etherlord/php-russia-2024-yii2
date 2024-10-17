<?php

declare(strict_types=1);

namespace app\modules\welcome;

use yii\base\Module as BaseModule;

final class Module extends BaseModule
{
    public function init(): void
    {
        parent::init();

        $this->params['welcome-message'] = getenv('WELCOME_MESSAGE') ?: env('WELCOME_MESSAGE');
    }
}
