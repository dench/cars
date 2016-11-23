<?php

namespace app\models;

use app\behaviors\CreatorBehavior;
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
 * @property integer $zone_id
 *
 * @property User $user
 * @property Robot $robot
 * @property Zone $zone
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
            [['user_id', 'zone_id', 'from', 'to'], 'required'],
            [['user_id', 'robot_id', 'zone_id'], 'integer'],
            [['from', 'to'], 'integer', 'on' => self::SCENARIO_TIMELINE],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['robot_id'], 'exist', 'skipOnError' => true, 'targetClass' => Robot::className(), 'targetAttribute' => ['robot_id' => 'id']],
            [['zone_id'], 'exist', 'skipOnError' => true, 'targetClass' => Zone::className(), 'targetAttribute' => ['zone_id' => 'id']],
            ['from', 'datetime', 'type' => DateValidator::TYPE_DATETIME, 'timestampAttribute' => 'from', 'on' => self::SCENARIO_ADMIN],
            ['to', 'datetime', 'type' => DateValidator::TYPE_DATETIME, 'timestampAttribute' => 'to', 'on' => self::SCENARIO_ADMIN],
            ['to', 'validateCompareTime'],
            [['from', 'to'], 'validateReserved'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADMIN] = ['user_id', 'robot_id', 'from', 'to', 'zone_id'];
        $scenarios[self::SCENARIO_TIMELINE] = ['from', 'to', 'zone_id'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => 'User ID',
            'robot_id' => 'Robot ID',
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'zone_id' => 'Zone ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZone()
    {
        return $this->hasOne(Zone::className(), ['id' => 'zone_id']);
    }

    public function validateCompareTime()
    {
        if ($this->to <= $this->from) {
            $this->addError('to', 'The "To" must be greater than the "From".');
        }
    }

    public function validateReserved($attribute, $params)
    {
        $robots = Robot::countRobots($this->zone_id);

        $query = self::find()->andWhere(['<', 'from', $this->$attribute])->andWhere(['>', 'to', $this->$attribute]);

        if ($attribute == 'to') {
            $query->orWhere(['and', ['>=', 'from', $this->from], ['<=', 'to', $this->to]]);
        }

        $query->andFilterWhere(['!=', 'id', $this->id]);

        if ($query->count() >= $robots || $query->andWhere(['user_id' => $this->user_id])->count()) {
            $this->addError($attribute, Yii::t('app', 'Time has been reserved.'));
        }
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
            $fi = date('i', $f);
            $ti = date('i', $f);
            if ($fi != 0 && $fi != 30) {
                $f -= abs(($fi < 30 ? 0 : 30) - $fi)*60;
            }
            if ($ti != 0 && $ti != 30) {
                $t += abs(($ti < 30 ? 30 : 0) - $ti)*60;
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

    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
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
