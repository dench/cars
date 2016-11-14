<?php

namespace app\models;

use Yii;
use yii\validators\DateValidator;

/**
 * This is the model class for table "timeline".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $robot_id
 * @property integer $from
 * @property integer $to
 *
 * @property User $user
 * @property Robot $robot
 */
class Timeline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'timeline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'robot_id', 'from', 'to', 'fromFormat', 'toFormat'], 'required'],
            [['user_id', 'robot_id', 'from', 'to'], 'integer'],
            [['fromFormat', 'toFormat'], 'date', 'type' => DateValidator::TYPE_DATETIME],
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
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'robot_id' => Yii::t('app', 'Robot ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
        ];
    }

    public function getFromFormat()
    {
        return Yii::$app->formatter->asDatetime($this->from ?? time());
    }

    public function setFromFormat($text)
    {
        $this->from = Yii::$app->formatter->asTimestamp($text);
    }

    public function getToFormat()
    {
        return Yii::$app->formatter->asDatetime($this->to ?? time());
    }

    public function setToFormat($text)
    {
        $this->to = Yii::$app->formatter->asTimestamp($text);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRobot()
    {
        return $this->hasOne(Robot::className(), ['id' => 'robot_id']);
    }
}
