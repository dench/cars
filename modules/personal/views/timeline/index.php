<?php
/** @var $this yii\web\View */
/** @var $count integer */

use app\widgets\TimelineTable;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?= TimelineTable::widget() ?>

<?php $form = ActiveForm::begin(); ?>
    <div id="fromto"></div>
    <?= Html::submitButton(Yii::t('app', 'Reserve'), ['class' => 'btn btn-primary btn-lg', 'disabled' => true]) ?>
<?php ActiveForm::end(); ?>