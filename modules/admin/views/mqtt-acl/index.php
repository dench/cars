<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\MqttAclSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mqtt Acl';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mqtt-acl-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Mqtt Acl', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'topic',
            'rw',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
