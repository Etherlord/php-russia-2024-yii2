<?php

declare(strict_types=1);

namespace app\modules\index\controllers;

use yii\web\Controller;

final class IndexController extends Controller
{
    public $enableCsrfValidation = false;

    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
