<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use Webmozart\Glob\Glob;

return static fn(Configuration $config): Configuration => $config
    ->setAdditionalFilesFor('app/php-russia-2024-yii2', [
        __FILE__,
        ...Glob::glob(__DIR__ . '/config/*.php'),
    ])
;
