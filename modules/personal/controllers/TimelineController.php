<?php

namespace app\modules\personal\controllers;

use app\models\Robot;
use app\models\Timeline;
use Yii;
use yii\base\Model;
use yii\web\Response;

class TimelineController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (isset($_POST['Timeline'])) {
            $models = [];
            foreach ($_POST['Timeline'] as $i) {
                $model = new Timeline();
                $model->scenario = Timeline::SCENARIO_TIMELINE;
                $models[] = $model;
            }
            if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
                foreach ($models as $model) {
                    $model->save(false);
                }
                return $this->redirect(['/personal/timeline']);
            }
        }

        $temp = Timeline::reserved();

        foreach ($temp as $k => $v) {
            //echo Yii::$app->formatter->asDatetime($k)."<br>";
        }

        return $this->render('index');
    }

    public function actionReserved()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $data['busy'] = Timeline::reserved();
        $data['me'] = Timeline::reserved(['user_id' => Yii::$app->user->id]);
        $data['passed'] = Timeline::passed();

        return $data;
    }

}
