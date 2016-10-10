<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $password_mqtt
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $zone_id
 * @property string $password
 *
 * @property MqttAcl[] $mqttAcls
 * @property Zone $zone
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DISABLED = 0;
    const STATUS_USER = 1;
    const STATUS_SUPER = 2;
    const STATUS_CAR = 3;

    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => self::className(), 'message' => Yii::t('app', 'Username already exists')],
            ['username', 'string', 'min' => 2, 'max' => 20],
            
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => Yii::t('app', 'E-mail already exists')],
            ['email', 'string', 'max' => 255],
            
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_USER],
            ['status', 'in', 'range' => [self::STATUS_USER, self::STATUS_DISABLED, self::STATUS_SUPER, self::STATUS_CAR]],

            ['zone_id', 'integer'],
            ['zone_id', 'exist', 'skipOnError' => true, 'targetClass' => Zone::className(), 'targetAttribute' => ['zone_id' => 'id']],

            ['password', 'string', 'min' => 6],
        ];
    }

    public static function statusList()
    {
        return [
            self::STATUS_USER => Yii::t('app', 'User'),
            self::STATUS_SUPER => Yii::t('app', 'Super'),
            self::STATUS_DISABLED => Yii::t('app', 'Disabled'),
            self::STATUS_CAR => Yii::t('app', 'Car')
        ];
    }

    public function getStatusName()
    {
        $a = self::statusList();
        return $a[$this->status];
    }

    public static function userList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'username');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'E-mail'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'zone_id' => Yii::t('app', 'Zone'),
            'password' => Yii::t('app', 'Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()->where('id = :id and status != :status', ['id' => $id, 'status' => self::STATUS_DISABLED])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->where('username = :username and status != :status', ['username' => $username, 'status' => self::STATUS_DISABLED])->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::find()->where('password_reset_token = :token and status != :status', ['token' => $token, 'status' => self::STATUS_DISABLED])->one();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZone()
    {
        return $this->hasOne(Zone::className(), ['id' => 'zone_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMqttAcls()
    {
        return $this->hasMany(MqttAcl::className(), ['user_id' => 'id']);
    }
}