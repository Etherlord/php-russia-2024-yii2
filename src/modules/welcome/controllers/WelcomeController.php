<?php

declare(strict_types=1);

namespace app\modules\welcome\controllers;

use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

final class WelcomeController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        /**
         * @psalm-suppress UndefinedClass
         */
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public function actionWelcome(): string
    {
        /**
         * @psalm-suppress UndefinedClass
         */
        return json_encode(\Yii::$app->getModule('welcome')->params['welcome-message']);
    }
}
