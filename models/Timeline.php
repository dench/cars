<?php

namespace app\models;

use Yii;
use app\behaviors\CreatorBehavior;
use yii\db\ActiveRecord;
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
class Timeline extends ActiveRecord
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
    public function behaviors()
    {
        return [
            CreatorBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'to', 'fromFormat', 'toFormat'], 'required'],
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

    public static function reservedFromTo($params = null)
    {
        $query = self::find()->andFilterWhere(['>=', 'to', @$params['to']])->andFilterWhere(['user_id' => @$params['user_id']])->asArray()->all();

        $items = [];

        foreach ($query as $t) {
            $items[] = [
                $t['from'],
                $t['to']
            ];
        }

        return $items;
    }

    /**
     * Ячейки времени которые уже зарезервированы
     */
    public static function reserved($params = null)
    {
        if (!isset($params['to'])) $params['to'] = time();

        $models = self::reservedFromTo($params);

        $items = [];

        foreach ($models as $m) {
            $f = $m[0];
            $t = $m[1];
            $n = ceil(($t-$f)/1800);
            for ($i = 0; $i < $n; $i++) {
                @$items[$f+1800*$i]++;
            }
        }

        if (isset($params['count'])) {
            foreach ($items as $k => $v) {
                if ($v >= $params['count']) {
                    unset($items[$k]);
                }
            }
        }

        return $items;
    }

    /**
     * Ячейки времени которые нельзя выбрать, потому что время уже прошло
     */
    public static function passed()
    {
        $items = [];
        $time = time();
        $mktime = mktime(0, 0, 0);
        for ($j = 0; $j < 48; $j++) {
            $t = $mktime + $j * 1800;
            if ($t < $time) {
                $items[$t] = $t;
            }
        }
        return $items;
    }
}
