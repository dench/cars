<?php

use app\models\Robot;
use app\models\Zone;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Robot */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'zone_id')->dropDownList(Zone::getList(['!=', 'status',  Zone::STATUS_DISABLED]), ['prompt' => '-']) ?>

<?= $form->field($model, 'status')->dropDownList(Robot::statusList()) ?>

<?= $form->field($model, 'mqtt_id')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>