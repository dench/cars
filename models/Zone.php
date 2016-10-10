<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "zone".
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property integer $status
 *
 * @property User $user
 * @property User[] $users
 */
class Zone extends \yii\db\ActiveRecord
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_TEST = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'user_id'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['status', 'default', 'value' => self::STATUS_DISABLED],
            ['status', 'in', 'range' => [self::STATUS_DISABLED, self::STATUS_ACTIVE, self::STATUS_TEST]],
        ];
    }

    public static function statusList()
    {
        return [
            self::STATUS_DISABLED => Yii::t('app', 'Disabled'),
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_TEST => Yii::t('app', 'Test')
        ];
    }

    public function getStatusName()
    {
        $a = self::statusList();
        return $a[$this->status];
    }

    public static function zoneList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'user_id' => 'User ID',
            'status' => 'Status',
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
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['zone_id' => 'id']);
    }
}
