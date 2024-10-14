<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

use yii\helpers\Html;

?>
<div class="site-error">

    <h1><?php echo Html::encode($name); ?></h1>

    <div class="alert alert-danger">
        <?php echo nl2br(Html::encode($message)); ?>
    </div>
</div>
