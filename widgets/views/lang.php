<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.11.16
 * Time: 11:54
 */

/** @var $current \app\widgets\Lang */
/** @var $langs \app\widgets\Lang */

use app\models\Language;
use yii\helpers\Html;
use yii\helpers\Url;

$to = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;

echo '<div id="lang">';
foreach (Language::nameList() as $key => $value) {
    echo Html::a($value, Url::to([$to,'lang_id' => $key]), (Yii::$app->language == $key ? ['class' => 'active']: false)) . ' ';
}
echo '</div>';

?>