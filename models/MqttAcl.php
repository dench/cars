<?php

namespace app\models;

/**
 * This is the model class for table "mqtt_acl".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $topic
 * @property integer $rw
 *
 * @property User $user
 */
class MqttAcl extends \yii\db\ActiveRecord
{
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
            [['user_id', 'topic', 'rw'], 'required'],
            [['user_id', 'rw'], 'integer'],
            [['topic'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'topic' => 'Topic',
            'rw' => 'Rw',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
