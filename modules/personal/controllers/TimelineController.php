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
            $models = array_fill(0, count($_POST['Timeline']), new Timeline());
            if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
                foreach ($models as $model) {
                    /** @var $model Timeline */
                    $model->save();
                }
                return $this->redirect(['/personal/timeline']);
            }
        }

        return $this->render('index', [
            'count' => Robot::countRobots(['zone_id' => 1])
        ]);
    }

    public function actionReserved()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $data['busy'] = Timeline::reserved();
        $data['me'] = Timeline::reserved(['user_id' => 1]);
        $data['passed'] = Timeline::passed();

        return $data;
    }

}
