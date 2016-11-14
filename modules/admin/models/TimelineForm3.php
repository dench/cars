<?php

namespace app\mod;

use app\models\Robot;
use app\models\Timeline;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * This is the model class for table "timeline".
 *
 * @property integer $user_id
 * @property integer $robot_id
 * @property string $day
 * @property string $from
 * @property string $to
 */
class TimelineForm extends Model
{
    public $user_id;
    public $robot_id;
    public $from;
    public $to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'robot_id', 'from', 'to'], 'required'],
            [['from', 'to'], 'string'],
            [['user_id', 'robot_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['robot_id'], 'exist', 'skipOnError' => true, 'targetClass' => Robot::className(), 'targetAttribute' => ['robot_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'robot_id' => Yii::t('app', 'Robot ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
        ];
    }

    public function create()
    {
        $timeline = new Timeline();

        $timeline->user_id = $this->user_id;
        $timeline->robot_id = $this->robot_id;
        $timeline->from = Yii::$app->formatter->asTimestamp($this->from);
        $timeline->to = Yii::$app->formatter->asTimestamp($this->to);

        return $timeline->save();
    }
}
