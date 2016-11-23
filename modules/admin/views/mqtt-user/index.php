<?php

use app\modules\admin\widgets\Box;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\MqttUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mqtt Users');
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
            ],
            [
                'label' => Yii::t('app', 'Name'),
                'value' => function ($model) {
                    if (empty($model->robot->id)) {
                        return  @$model->user->username;
                    } else {
                        return  @$model->robot->name;
                    }
                }
            ],
            'super',

            ['class' => 'app\components\ActionColumnFa'],
        ],
    ]); ?>

<?php Box::end(); ?>
