<?php

use app\modules\admin\widgets\Box;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Robot */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Robot',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Robots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<?php Box::begin(); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<?php Box::end(); ?>
