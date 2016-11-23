<?php

namespace app\controllers;

use app\models\MqttAcl;
use app\models\MqttUser;
use app\models\Robot;
use app\models\Timeline;
use app\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;

class GameController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'start' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $timeline = Timeline::nextGame();

        return $this->render('index', [
            'timeline' => $timeline,
        ]);
    }

    public function actionStart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post();
            $id = explode(":", $post['id']);

            $timeline = Timeline::findOne($id);

            if (!$timeline) return false;

            if ($timeline->user_id != Yii::$app->user->id) return false;

            if ($timeline->from > time() || $timeline->to <= time()) return false;

            if (!$timeline->robot_id) {
                $robots = Robot::freeRobots($timeline->zone_id);
                $timeline->robot_id = array_shift($robots);
                $timeline->save();
            }

            $user = User::findOne($timeline->user_id);

            if ($user->mqtt_id) {
                $mqtt = MqttUser::findOne($user->mqtt_id);
            } else {
                $mqtt = new MqttUser();
            }
            $mqtt->password = substr(md5(rand(10000, 99999)), 0, 10);
            $mqtt->save();

            MqttAcl::createAcls($mqtt->id, $timeline->robot_id, $timeline->zone_id);

            $data['password'] = $mqtt->password;

            return $data;
        }
        return false;
    }

}
