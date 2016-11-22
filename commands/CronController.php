<?php

namespace app\commands;

use app\models\Timeline;
use yii\console\Controller;


class CronController extends Controller
{
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }

    public function actionSetRobot2()
    {
        $time = time();

        //->where(['>', 'from', $time+60])

        $temp = Timeline::find()->andWhere(['robot_id' => null])->andWhere(['>', 'from', $time+60])->andWhere(['<', 'to', $time])->all();

        foreach ($temp as $t) {
            echo $t->id . "\n";
        }
    }
}
