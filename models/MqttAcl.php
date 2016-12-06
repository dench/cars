<?php

namespace app\models;
use Yii;

/**
 * This is the model class for table "mqtt_acl".
 *
 * @property integer $id
 * @property integer $mqtt_id
 * @property string $topic
 * @property integer $rw
 *
 * @property MqttUser $client
 */
class MqttAcl extends \yii\db\ActiveRecord
{
    const READ_ONLY = 1;
    const WRITE_ONLY = 2;
    const READ_WRITE = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mqtt_acl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mqtt_id', 'topic'], 'required'],
            [['mqtt_id', 'rw'], 'integer'],
            [['topic'], 'string', 'max' => 255],
            [['mqtt_id'], 'exist', 'skipOnError' => true, 'targetClass' => MqttUser::className(), 'targetAttribute' => ['mqtt_id' => 'id']],
            ['topic', 'unique', 'targetAttribute' => ['topic', 'mqtt_id'], 'targetClass' => self::className()],
            ['rw', 'default', 'value' => self::READ_ONLY],
            ['rw', 'in', 'range' => [self::READ_ONLY, self::WRITE_ONLY, self::READ_WRITE]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mqtt_id' => 'Mqtt ID',
            'topic' => 'Topic',
            'rw' => 'Rw',
        ];
    }

    public static function rwList()
    {
        return [
            self::READ_ONLY => Yii::t('app', 'Read only'),
            self::WRITE_ONLY => Yii::t('app', 'Write only'),
            self::READ_WRITE => Yii::t('app', 'Read & write'),
        ];
    }

    public function getRwName()
    {
        $a = self::rwList();
        return $a[$this->rw];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(MqttUser::className(), ['id' => 'mqtt_id']);
    }

    /**
     * Установка прав доступа пользователю к топику робота
     *
     * @param $mqtt_id
     * @param $robot_id
     * @param $zone_id
     * @return bool
     */
    public static function createAcls($mqtt_id, $robot_id, $zone_id)
    {
        if (!$zone = Zone::findOne($zone_id)) return false;

        if (!$robot = Robot::findOne($robot_id)) return false;

        $acl = self::find()->andWhere(['mqtt_id' => $mqtt_id])->andWhere(['like', 'topic', '#'])->one();

        if (!$acl) {
            $acl = new MqttAcl();
            $acl->mqtt_id = $mqtt_id;
            $acl->rw = self::WRITE_ONLY;
        }

        $topic = $zone->name . "/" . $robot->name . "/#";


        if ($acl->topic == $topic) {
            return false;
        } else {
            $acl->topic = $topic;
        }

        if ($old = self::findOne(['topic' => $acl->topic, 'rw' => self::WRITE_ONLY])) {
            $old->topic = "/none/#";
            $old->save();
        }

        $acl->save();

        return true;
    }
}
