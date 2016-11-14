<?php

use app\modules\admin\widgets\Box;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Timeline */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Timeline',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Timelines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<?php Box::begin(); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<?php Box::end(); ?>
