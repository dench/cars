<?php

/**
 * Created by PhpStorm.
 * User: dench
 * Date: 28.10.16
 * Time: 13:17
 */

namespace app\widgets;

use yii\helpers\Html;

class H1
{
    public static function run($title = false)
    {
        if ($title) {
            return '<h1 class="text-xs-center">' . Html::encode($title) . '</h1>';
        } else {
            return '';
        }
    }
}