<?php

declare(strict_types=1);

namespace app\modules\welcome\controllers;

use yii\web\Controller;
use yii\web\Response;

final class WelcomeController extends Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action): bool
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public function actionWelcome(): string
    {
        return json_encode(
            \Yii::$app->getModule('welcome')?->params['welcome-message']
            ?? throw new \RuntimeException("Request failed. Can't get welcome message param"),
        );
    }
}
