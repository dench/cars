<?php

use app\modules\admin\widgets\Box;

/* @var $this yii\web\View */
/* @var $model app\models\MqttUser */

$this->title = Yii::t('app', 'Create Mqtt User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mqtt Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin(); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<?php Box::end(); ?>
