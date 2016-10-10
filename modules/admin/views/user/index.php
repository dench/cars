<?php

use app\components\SetColumn;
use app\models\User;
use app\models\Zone;
use app\modules\admin\widgets\Box;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin([
    'footer' => Html::a(Yii::t('app', 'Create user'), ['create'], ['class' => 'btn btn-success'])
]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '70'],
            ],
            'username',
            'email:email',
            [
                'class' => SetColumn::className(),
                'attribute' => 'status',
                'name' => 'statusName',
                'filter' => User::statusList(),
            ],
            [
                'class' => SetColumn::className(),
                'attribute' => 'zone_id',
                'name' => 'zone.name',
                'filter' => Zone::zoneList(),
            ],
            'created_at:date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

<?php Box::end(); ?>