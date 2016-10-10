<?php

use app\modules\admin\widgets\Box;

/* @var $this yii\web\View */
/* @var $model app\models\Zone */

$this->title = Yii::t('app', 'Create Zone');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin(); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<?php Box::end(); ?>
