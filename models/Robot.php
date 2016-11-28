<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "robot".
 *
 * @property integer $id
 * @property integer $mqtt_id
 * @property string $name
 * @property integer $zone_id
 * @property integer $status
 * @property string $address
 *
 * @property MqttUser $client
 * @property Zone $zone
 */
class Robot extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'robot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mqtt_id', 'zone_id', 'status'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 20],
            [['mqtt_id'], 'exist', 'skipOnError' => true, 'targetClass' => MqttUser::className(), 'targetAttribute' => ['mqtt_id' => 'id']],
            [['zone_id'], 'exist', 'skipOnError' => true, 'targetClass' => Zone::className(), 'targetAttribute' => ['zone_id' => 'id']],
            ['status', 'default', 'value' => self::STATUS_ENABLED],
            ['status', 'in', 'range' => [self::STATUS_ENABLED, self::STATUS_DISABLED]],
            [['address'], 'url']
        ];
    }

    public static function statusList()
    {
        return [
            self::STATUS_DISABLED => Yii::t('app', 'Disabled'),
            self::STATUS_ENABLED => Yii::t('app', 'Enabled')
        ];
    }

    public function getStatusName()
    {
        $a = self::statusList();
        return $a[$this->status];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mqtt_id' => 'Mqtt ID',
            'name' => Yii::t('app', 'Name'),
            'zone_id' => Yii::t('app', 'Zone'),
            'status' => Yii::t('app', 'Status'),
            'address' => Yii::t('app', 'Address'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(MqttUser::className(), ['id' => 'mqtt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZone()
    {
        return $this->hasOne(Zone::className(), ['id' => 'zone_id']);
    }

    /**
     * Количество роботов на зоне
     *
     * @param null $condition
     * @return int
     */
    public static function countRobots($zone_id)
    {
        return self::find()->andWhere(['zone_id' => $zone_id])->andWhere(['!=', 'status', self::STATUS_DISABLED])->count();
    }

    /**
     * Список robot_id свободных роботов на полигоне
     *
     * @param $zone_id
     * @return array
     */
    public static function freeRobots($zone_id)
    {
        $busy = self::busyRobots($zone_id);

        $all = self::find()->select(['id'])->andWhere(['zone_id' => $zone_id])->andWhere(['!=', 'status', self::STATUS_DISABLED])->column();

        return array_diff($all, $busy);
    }

    /**
     * Список robot_id занятых роботов на полигоне
     *
     * @param $zone_id
     * @param null $time
     * @return array
     */
    public static function busyRobots($zone_id, $time = null)
    {
        return Timeline::busyRobots($zone_id, $time);
    }
}
