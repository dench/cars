<?php

namespace app\controllers;

use app\models\Timeline;
use app\models\Zone;
use Yii;
use yii\base\Model;
use yii\web\Response;

class TimelineController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (isset($_POST['Timeline'])) {
            $zone_id = Yii::$app->request->post('zone_id');
            $models = [];
            foreach ($_POST['Timeline'] as $i) {
                $models[] = new Timeline([
                    'scenario' => Timeline::SCENARIO_TIMELINE,
                    'zone_id' => $zone_id
                ]);
            }
            if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
                foreach ($models as $model) {
                    $model->save(false);
                }
                return $this->redirect(['/timeline/index']);
            }
        }

        $temp = Timeline::reserved();

        foreach ($temp as $k => $v) {
            //echo Yii::$app->formatter->asDatetime($k)."<br>";
        }

        $zone = Zone::findOne(1);

        return $this->render('index', [
            'zone' => $zone
        ]);
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
