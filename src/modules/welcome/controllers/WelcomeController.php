<?php

declare(strict_types=1);

namespace app\modules\welcome\controllers;

use yii\base\Module;
use yii\web\Controller;

final class WelcomeController extends Controller
{
    private readonly string $welcomeMessage;

    public function __construct(
        string $id,
        Module $module,
        array $config = [],
    ) {
        parent::__construct($id, $module, $config);

        $this->welcomeMessage = \Yii::$app->getModule('welcome')?->params['welcome-message']
            ?? throw new \RuntimeException("Request failed. Can't get welcome message param");
    }

    public function actionWelcome(): string
    {
        return $this->welcomeMessage;
    }
}
