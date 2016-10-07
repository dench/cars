<?php

namespace app\modules\page\models;

use app\behaviors\TitleBehavior;
use app\modules\user\models\User;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use app\behaviors\CreatorBehavior;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $slug
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $enabled
 *
 * @property User $user
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            CreatorBehavior::className(),
            TitleBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['text'], 'string'],
            [['slug'], 'string', 'max' => 100],
            [['name', 'title', 'description', 'keywords'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['name', 'title', 'slug', 'description', 'keywords', 'text'], 'trim'],
            [['enabled'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => Yii::t('app', 'Автор'),
            'slug' => Yii::t('app', 'ЧПУ'),
            'name' => Yii::t('app', 'Название'),
            'title' => Yii::t('app', 'Заголовок'),
            'description' => Yii::t('app', 'Описание'),
            'keywords' => Yii::t('app', 'Ключевые слова'),
            'text' => Yii::t('app', 'Текст'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Изменено'),
            'enabled' => Yii::t('app', 'Включено'),
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
