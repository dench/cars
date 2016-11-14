<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.11.16
 * Time: 11:54
 */

/** @var $current \app\widgets\Lang */
/** @var $langs \app\widgets\Lang */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

ActiveForm::begin([
    'action' => ['site/lang'],
    'id' => 'lang'
]);

echo Html::dropDownList('lang', $current->id, $langs, ['class' => 'form-control', 'onchange' => '']);

ActiveForm::end();

?>