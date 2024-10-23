<?php

declare(strict_types=1);

namespace app\infrastructure\models;

use yii\web\IdentityInterface;

final class User implements IdentityInterface
{
    public static function findIdentity($id): self
    {
        return new self();
    }

    public static function findIdentityByAccessToken($token, $type = null): self
    {
        return new self();
    }

    public function getId(): int
    {
        return 1;
    }

    public function getAuthKey(): string
    {
        return '';
    }

    public function validateAuthKey($authKey): bool
    {
        return true;
    }
}
