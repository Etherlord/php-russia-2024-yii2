<?php

declare(strict_types=1);

namespace app\modules\queue\jobs;

use yii\base\BaseObject;
use yii\queue\JobInterface;

final class Task extends BaseObject implements JobInterface
{
    public function __construct(
        public string $message,
    ) {
        parent::__construct();
    }

    public function execute($queue): void
    {
        \Yii::info(\sprintf('Received message = "%s"', $this->message));
    }
}
