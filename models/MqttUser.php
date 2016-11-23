<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mqtt_user".
 *
 * @property integer $id
 * @property string $pw
 * @property boolean $super
 *
 * @property MqttAcl[] $mqttAcls
 * @property Robot $robot
 * @property User $user
 */
class MqttUser extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mqtt_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password'], 'required', 'on' => self::SCENARIO_CREATE],
            [['password'], 'string', 'max' => 100],
            [['super'], 'boolean'],
        ];
    }

    public static function superList()
    {
        return [
            Yii::t('app', 'No'),
            Yii::t('app', 'Yes'),
        ];
    }

    public function getSuperName()
    {
        $a = self::superList();
        return $a[$this->super];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'password' => Yii::t('app', 'Password'),
            'super' => Yii::t('app', 'Super'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMqttAcls()
    {
        return $this->hasMany(MqttAcl::className(), ['mqtt_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRobot()
    {
        return $this->hasOne(Robot::className(), ['mqtt_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['mqtt_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (!empty($this->password)) {
            $this->pw = exec("np -p " . escapeshellarg($this->password));
        }

        return parent::beforeSave($insert);
    }
}
