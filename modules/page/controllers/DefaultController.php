<?php

namespace app\modules\page\controllers;

use app\modules\page\models\Page;
use yii\web\Controller;

/**
 * Default controller for the `page` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($slug)
    {
        $model = Page::findOne(['slug' => $slug]);
        
        return $this->render('index', [
            'model' => $model
        ]);
    }
}
