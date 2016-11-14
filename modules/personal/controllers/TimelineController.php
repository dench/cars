<?php

namespace app\modules\personal\controllers;

use DateTime;

class TimelineController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
