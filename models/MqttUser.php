<?php

namespace app\models;

/**
 * This is the model class for table "mqtt_user".
 *
 * @property integer $id
 * @property string $pw
 * @property integer $super
 *
 * @property User $user
 */
class MqttUser extends \yii\db\ActiveRecord
{
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
            [['id', 'pw'], 'required'],
            [['id', 'super'], 'integer'],
            [['pw'], 'string', 'max' => 127],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pw' => 'Pw',
            'super' => 'Super',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }
}
