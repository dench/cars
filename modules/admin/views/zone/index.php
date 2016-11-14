<?php

use app\components\SetColumn;
use app\models\Zone;
use app\modules\admin\widgets\Box;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Zones');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin([
    'footer' => Html::a(Yii::t('app', 'Create zone'), ['create'], ['class' => 'btn btn-success'])
]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'grid-view table-responsive'],
        'columns' => [

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '70'],
            ],
            'name',
            'user.username',
            [
                'class' => SetColumn::className(),
                'attribute' => 'status',
                'name' => 'statusName',
                'filter' => Zone::statusList(),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

<?php Box::end(); ?>
