<?php

use app\modules\admin\widgets\Box;

/* @var $this yii\web\View */
/* @var $model app\models\Robot */

$this->title = Yii::t('app', 'Create Robot');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Robots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin(); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<?php Box::end(); ?>
