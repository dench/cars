<?php

use app\modules\admin\widgets\Box;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\RobotSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Robots');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin([
    'footer' => Html::a(Yii::t('app', 'Create robot'), ['create'], ['class' => 'btn btn-success'])
]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'grid-view table-responsive'],
        'columns' => [

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '70'],
            ],
            'mqtt_id',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

<?php Box::end(); ?>
