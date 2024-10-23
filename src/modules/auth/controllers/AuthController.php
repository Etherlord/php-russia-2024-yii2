<?php

declare(strict_types=1);

namespace app\modules\auth\controllers;

use agielks\yii2\jwt\Jwt;
use yii\base\InvalidConfigException;
use yii\web\Controller;

final class AuthController extends Controller
{
    /**
     * @throws InvalidConfigException
     */
    public function actionAuthenticate(): array
    {
        $now = new \DateTimeImmutable();
        /** @var Jwt $jwt */
        $jwt = \Yii::$app->get('jwt');

        $token = $jwt
            ->builder()
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->getToken($jwt->signer(), $jwt->key())
            ->toString()
        ;

        return [
            'token' => $token,
        ];
    }
}
