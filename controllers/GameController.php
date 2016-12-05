<?php

namespace app\controllers;

use app\models\MqttAcl;
use app\models\MqttUser;
use app\models\Robot;
use app\models\Timeline;
use app\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\httpclient\Client;
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

    /**
     * @return bool
     */
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

            $robot = Robot::findOne($timeline->robot_id);
            $user = User::findOne($timeline->user_id);
            if ($user->mqtt_id) {
                $mqtt = MqttUser::findOne($user->mqtt_id);
            } else {
                $mqtt = new MqttUser();
            }
            $client = new Client();
            $client->baseUrl = $robot->address;

            $response = $client->get('get_params.cgi', ['user' => $robot->name, 'pwd' => $robot->password])->send();

            preg_match('/user2_name="(.*?)".+?var user2_pwd="(.*?)"/s', $response->content, $out);

            if ($out[1] != $user->username) {

                $mqtt->password = substr(md5(rand(10000, 99999)), 0, 8);
                $mqtt->save();

                MqttAcl::createAcls($mqtt->id, $timeline->robot_id, $timeline->zone_id);

                $data['user'] = ($user->username == 'admin') ? 'none' : $user->username;
                $data['password'] = $mqtt->password;

                $response = $client->get('set_users.cgi', [
                    'loginuse' => $robot->name,
                    'loginpas' => $robot->password,
                    'user1' => '',
                    'pwd1' => '',
                    'pri1' => 1,
                    'user2' => $data['user'],
                    'pwd2' => $data['password'],
                    'pri2' => 2,
                    'user3' => $robot->name,
                    'pwd3' => $robot->password,
                    'pri3' => 255
                ])->send();

                if (strpos($response, '"ok"')) {
                    $response = $client->get('reboot.cgi', ['user' => $robot->name, 'pwd' => $robot->password]);
                    if (strpos($response, '"ok"')) {
                        $data['status'] = "Ok #reboot";
                    } else {
                        $data['status'] = "Error #reboot";
                    }
                } else {
                    $data['status'] = "Error #set_users";
                }

            } else {
                $data['user'] = $out[1];
                $data['password'] = $out[2];
                $data['status'] = "Ok #match";
            }

            $data['url'] = $robot->address."/videostream.cgi?user=".$data['user']."&pwd=".$data['password'];

            return $data;
        }
        return false;
    }

}
