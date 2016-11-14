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
        'options' => ['class' => 'grid-view table-responsive'],
        'columns' => [

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '70'],
            ],
            [
                'attribute' => 'mqtt_id',
                'headerOptions' => ['width' => '70'],
            ],
            'topic',
            [
                'class' => SetColumn::className(),
                'attribute' => 'rw',
                'name' => 'rwName',
                'filter' => MqttAcl::rwList(),
            ],

            ['class' => 'app\components\ActionColumnFa'],
        ],
    ]); ?>

<?php Box::end(); ?>
