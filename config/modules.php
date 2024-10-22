<?php

declare(strict_types=1);

use app\modules\index\Module;

return [
    'index' => ['class' => Module::class],
    'welcome' => ['class' => app\modules\welcome\Module::class],
    's3' => ['class' => app\modules\s3\Module::class],
    'queue' => ['class' => app\modules\queue\Module::class],
];
