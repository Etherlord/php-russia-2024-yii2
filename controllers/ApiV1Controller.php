<?php

declare(strict_types=1);

namespace app\controllers;

use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

final class ApiV1Controller extends Controller
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

    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionWelcome(): string
    {
        return json_encode(['ss' => 'sss']);
    }
}
