<?php

use app\modules\admin\widgets\Box;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\Page */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Страницы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Box::begin([
    'footer' => Html::a(Yii::t('app', 'Изменить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])
        . ' ' .
        Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить?'),
                'method' => 'post',
            ],
        ])
]); ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'slug',
            'name',
            'title',
            'description',
            'keywords',
            'created_at',
            'updated_at',
            'enabled',
            'text:ntext',
        ],
    ]) ?>
    
<?php Box::end(); ?>
