<?php

namespace app\modules\main\controllers;

use app\modules\catalog\helpers\ProductCategoryHelper;
use yii\helpers\Json;

class AjaxController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCategory()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            if ($parents = $_POST['depdrop_parents']) {
                $temp = ProductCategoryHelper::level($parents[0]);
                $out = [];
                foreach ($temp as $k => $v) {
                    $out[] = [
                        'id' => $k,
                        'name' => $v
                    ];
                }
            }
        }
        print Json::encode(['output' => $out, 'selected' => '']);
    }

}
