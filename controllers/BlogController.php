<?php

namespace app\controllers;

use app\models\Page;

class BlogController extends \yii\web\Controller
{
    public function actionIndex()
    {
        Page::viewPage('blog');

        return $this->render('index');
    }

}
