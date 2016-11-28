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
            $mqtt->password = substr(md5(rand(10000, 99999)), 0, 8);
            $mqtt->save();

            MqttAcl::createAcls($mqtt->id, $timeline->robot_id, $timeline->zone_id);

            $data['user'] = ($user->username == 'admin') ? 'none' : $user->username;
            $data['password'] = $mqtt->password;

            $robot = Robot::findOne($timeline->robot_id);

            $url = $robot->address."/set_users.cgi?loginuse=admin&loginpas=rclink&user1=&pwd1=&pri1=1&user2=".$data['user']."&pwd2=".$data['password']."&pri2=2&user3=admin&pwd3=rclink&pri3=255";

            $result = file_get_contents($url);

            if (strpos($result, '"ok"')) {
                $url = $robot->address."/reboot.cgi?user=admin&pwd=rclink";
                $result = file_get_contents($url);
                if (strpos($result, '"ok"')) {
                    $data['result'] = "OK";
                    $data['url'] = $robot->address."/videostream.cgi?user=".$data['user']."&pwd=".$data['password'];
                } else {
                    $data['result'] = "Error #reboot";
                }
            } else {
                $data['result'] = "Error #set_users";
            }

            return $data;
        }
        return false;
    }

}
