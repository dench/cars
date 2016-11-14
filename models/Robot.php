<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "robot".
 *
 * @property integer $id
 * @property integer $mqtt_id
 * @property string $name
 *
 * @property MqttUser $client
 */
class Robot extends \yii\db\ActiveRecord
{
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
            [['mqtt_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 20],
            [['mqtt_id'], 'exist', 'skipOnError' => true, 'targetClass' => MqttUser::className(), 'targetAttribute' => ['mqtt_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mqtt_id' => Yii::t('app', 'Mqtt ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(MqttUser::className(), ['id' => 'mqtt_id']);
    }
}
