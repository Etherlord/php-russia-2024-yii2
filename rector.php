<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->parallel();
    $rectorConfig->cacheDirectory(__DIR__ . '/var/rector');
    $rectorConfig->paths([
        __DIR__ . '/commands',
        __DIR__ . '/controllers',
        __DIR__ . '/web',
    ]);
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_83,
    ]);
    $rectorConfig->skip([
        AddOverrideAttributeToOverriddenMethodsRector::class,
    ]);
};
