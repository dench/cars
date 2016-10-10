<?php

use app\modules\admin\widgets\Box;

/* @var $this yii\web\View */
/* @var $model app\models\Zone */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Zone',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<?php Box::begin(); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<?php Box::end(); ?>
