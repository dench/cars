<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MqttUser */

$this->title = 'Create Mqtt User';
$this->params['breadcrumbs'][] = ['label' => 'Mqtt Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mqtt-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
