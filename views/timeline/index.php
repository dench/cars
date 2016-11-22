<?php
/** @var $this yii\web\View */
/** @var $zone app\models\Zone */

use app\widgets\TimelineTable;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

echo \app\models\Timeline::find()->where(
    ['and',
        ['!=', 'id', 2],
        ['or',
            ['and',
                ['<', 'from', 1],
                ['>', 'to', 1]
            ],
            ['and',
                ['<', 'from', 1],
                ['>', 'to', 1]
            ]
        ]
    ])->createCommand()->rawSql;

?>

<?= TimelineTable::widget(['zone_id' => $zone->id]) ?>

<?php $form = ActiveForm::begin(); ?>
    <div id="fromto"></div>
    <?= Html::input('hidden', 'zone_id', $zone->id) ?>
    <?= Html::submitButton(Yii::t('app', 'Reserve'), ['class' => 'btn btn-primary btn-lg', 'disabled' => true]) ?>
<?php ActiveForm::end(); ?>
