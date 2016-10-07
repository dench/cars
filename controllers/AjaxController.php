<?php

namespace app\controllers;

use yii\helpers\Json;

class AjaxController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
