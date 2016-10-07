<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MqttAcl */

$this->title = 'Create Mqtt Acl';
$this->params['breadcrumbs'][] = ['label' => 'Mqtt Acls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mqtt-acl-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
