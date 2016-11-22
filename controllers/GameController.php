<?php

namespace app\controllers;

use app\models\Timeline;
use Yii;

class GameController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $fromline = Timeline::reserved(['user_id' => Yii::$app->user->identity->getId()]);

        $from = current($fromline)-1;
        $to = end($fromline);

        $timeline = Timeline::find()->andWhere(['user_id' => Yii::$app->user->identity->getId()])->andWhere(['>', 'from', time()])->andWhere(['>', 'to', time()])->asArray()->one();

        return $this->render('index', [
            'from' => $from,
            'timeline' => $timeline,
        ]);
    }

}
