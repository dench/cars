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
        'options' => ['class' => 'grid-view table-responsive'],
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '70'],
                'contentOptions' => ['class' => 'text-right'],
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
                'attribute' => 'energy',
                'filter' => '<div class="input-group double-input">' .
                            Html::activeTextInput($searchModel, 'energy_from', ['class' => 'form-control']) .
                            Html::activeTextInput($searchModel, 'energy_to', ['class' => 'form-control']) .
                            '</div>',
                'headerOptions' => ['width' => '150'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            'created_at:date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

<?php Box::end(); ?>