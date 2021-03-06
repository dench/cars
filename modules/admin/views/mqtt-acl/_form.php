<?php

use app\models\MqttAcl;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MqttAcl */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'mqtt_id')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'topic')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'rw')->dropDownList(MqttAcl::rwList()) ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
