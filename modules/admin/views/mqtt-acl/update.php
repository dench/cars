<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MqttAcl */

$this->title = 'Update Mqtt Acl: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mqtt Acl', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mqtt-acl-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
