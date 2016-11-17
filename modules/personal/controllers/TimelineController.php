<?php

namespace app\modules\personal\controllers;

use app\models\Robot;
use app\models\Timeline;
use Yii;
use yii\base\Model;

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

        /*$time = time();
        $mktime = mktime(0, 0, 0);
        $models = Timeline::reserved($time);
        for ($i = 0; $i < 7; $i++) {
            $day = $i*3600*24;
            for ($j = 0; $j < 48; $j++) {
                $t = $mktime+$day+$j*1800;
            }
        }*/

        $count = Robot::countRobots(['zone_id' => 1]);

        $time = time();
        $from = Timeline::reservedCount($time);

        return $this->render('index', [
            'from' => $from,
            'count' => $count
        ]);
    }

}
