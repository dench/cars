<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Timeline */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'user_id')->textInput() ?>

<?= $form->field($model, 'robot_id')->textInput() ?>

<?= $form->field($model, 'from')->textInput(['value' => Yii::$app->formatter->asDatetime($model->from ?? (time() + abs(30 - date('i', time()))*60))]) ?>

<?= $form->field($model, 'to')->textInput(['value' => Yii::$app->formatter->asDatetime($model->to ?? (time() + abs(30 - date('i', time()))*60))]) ?>

<div class="form-group">
    <?= Html::submitButton(!$model->user_id ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => !$model->user_id ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
