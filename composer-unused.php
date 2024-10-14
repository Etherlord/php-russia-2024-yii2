<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;

return static fn(Configuration $config): Configuration => $config
    ->addNamedFilter(NamedFilter::fromString('php'))
    ->addNamedFilter(NamedFilter::fromString('yiisoft/yii2'))
    ->addNamedFilter(NamedFilter::fromString('yiithings/yii2-dotenv'))
;
