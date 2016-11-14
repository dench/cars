<?php

use app\models\MqttUser;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MqttUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mqtt-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pw')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'super')->dropDownList(MqttUser::superList()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
