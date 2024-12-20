<?php

declare(strict_types=1);

namespace app\modules\queue\controllers;

use agielks\yii2\jwt\JwtBearerAuth;
use app\modules\queue\jobs\Task;
use app\modules\queue\models\SendTaskForm;
use yii\base\UnknownPropertyException;
use yii\queue\file\Queue;
use yii\rest\Controller;

final class SendController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtBearerAuth::class,
        ];

        return $behaviors;
    }

    /**
     * @throws UnknownPropertyException
     */
    public function actionSendTask(): array
    {
        $sendTaskForm = new SendTaskForm(\Yii::$app->request->post('message'));
        if (!$sendTaskForm->validate()) {
            \Yii::$app->response->setStatusCode(400);

            return [
                'errors' => $sendTaskForm->getErrors('message'),
            ];
        }

        /**
         * @var Queue
         * @psalm-suppress UndefinedMagicPropertyFetch
         */
        $queue = \Yii::$app->queue;
        \assert(\is_string($sendTaskForm->message));
        $queue->push(new Task($sendTaskForm->message));

        return [
            'result' => 'ok',
        ];
    }
}
