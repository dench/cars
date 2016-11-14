<?php

namespace app\controllers;

class BlogController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
