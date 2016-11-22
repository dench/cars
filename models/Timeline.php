<?php

namespace app\models;

use Yii;
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
    const SCENARIO_ADMIN = 'admin';
    const SCENARIO_TIMELINE = 'register';

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
            [['from', 'to'], 'required'],
            [['user_id', 'robot_id'], 'integer'],
            [['from', 'to'], 'integer', 'on' => self::SCENARIO_TIMELINE],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['robot_id'], 'exist', 'skipOnError' => true, 'targetClass' => Robot::className(), 'targetAttribute' => ['robot_id' => 'id']],
            ['from', 'datetime', 'type' => DateValidator::TYPE_DATETIME, 'timestampAttribute' => 'from', 'on' => self::SCENARIO_ADMIN],
            ['to', 'datetime', 'type' => DateValidator::TYPE_DATETIME, 'timestampAttribute' => 'to', 'on' => self::SCENARIO_ADMIN],
            ['to', 'compare', 'compareAttribute' => 'from', 'operator' => '>'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADMIN] = ['user_id', 'robot_id', 'from', 'to'];
        $scenarios[self::SCENARIO_TIMELINE] = ['from', 'to'];
        return $scenarios;
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
        $query = self::find()
            ->andFilterWhere(['<', 'to', @$params['to']])
            ->andFilterWhere(['>=', 'from', @$params['from']])
            ->andFilterWhere(['user_id' => @$params['user_id']])
            ->asArray()->all();

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
        if (empty($params['from'])) {
            $params['from'] = time();
        }

        if (empty($params['to'])) {
            $params['to'] = time()+3600*24*7;
        }

        $models = self::reservedFromTo($params);

        $items = [];

        foreach ($models as $m) {
            $f = $m[0];
            $t = $m[1];
            if (date('i', $f) != 0 && date('i', $f) != 30) {
                if ($f < 30) {
                    $f = $f - abs(0 - date('i', $f))*60;
                } else {
                    $f = $f - abs(30 - date('i', $f))*60;
                }
            }
            if (date('i', $t) != 0 && date('i', $t) != 30) {
                if ($t < 30) {
                    $t = $t + abs(30 - date('i', $t))*60;
                } else {
                    $t = $t + abs(0 - date('i', $t))*60;
                }
            }
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

    public function beforeSave($insert)
    {
        if (empty($this->user_id)) {
            $this->user_id = Yii::$app->user->id;
        }
        if ($to = self::findOne(['to' => $this->from, 'user_id' => $this->user_id])) {
            $this->from = $to->from;
            $to->delete();
        }

        if ($from = self::findOne(['from' => $this->to, 'user_id' => $this->user_id])) {
            $this->to = $from->to;
            $from->delete();
        }

        return parent::beforeSave($insert);
    }
}
