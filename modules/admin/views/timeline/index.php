<?php

use app\modules\admin\widgets\Box;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\TimelineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Timelines');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin([
    'footer' => Html::a(Yii::t('app', 'Create time'), ['create'], ['class' => 'btn btn-success'])
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
            [
                'attribute' => 'username',
                'value' => 'user.username',
            ],
            [
                'attribute' => 'robotname',
                'value' => 'robot.name',
            ],
            'from:datetime',
            'to:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

<?php Box::end(); ?>
