<?php

namespace app\models;
use Yii;

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
            [['user_id', 'topic', 'rw'], 'required'],
            [['user_id', 'rw'], 'integer'],
            [['topic'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['topic', 'unique', 'targetAttribute' => ['topic', 'user_id'], 'targetClass' => self::className()],
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
            'user_id' => 'User ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'id']);
    }
}
