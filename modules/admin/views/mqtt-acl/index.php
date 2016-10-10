<?php

use app\components\SetColumn;
use app\models\MqttAcl;
use app\modules\admin\widgets\Box;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\MqttAclSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mqtt Acl';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin([
    'footer' => Html::a(Yii::t('app', 'Create ACL'), ['create'], ['class' => 'btn btn-success'])
]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '70'],
            ],
            [
                'attribute' => 'username',
                'value' => 'user.username',
            ],
            'topic',
            [
                'class' => SetColumn::className(),
                'attribute' => 'rw',
                'name' => 'rwName',
                'filter' => MqttAcl::rwList(),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

<?php Box::end(); ?>
