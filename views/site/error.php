<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use app\widgets\H1;
use yii\helpers\Html;

$this->title = $name;
?>

<?= H1::run($this->title); ?>

<div class="alert alert-danger">
    <?= nl2br(Html::encode($message)) ?>
</div>

<p>
    The above error occurred while the Web server was processing your request.
</p>
<p>
    Please contact us if you think this is a server error. Thank you.
</p>
