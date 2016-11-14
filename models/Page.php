<?php

namespace app\models;

use app\behaviors\LanguageBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $slug
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $enabled
 *
 * Language
 *
 * @property string $name
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $text
 */
class Page extends ActiveRecord
{
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
    public function behaviors()
    {
        return [
            LanguageBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'name', 'title'], 'required'],
            [['slug', 'name', 'title', 'keywords'], 'string', 'max' => 255],
            [['description', 'text'], 'string'],
            [['slug', 'name', 'title', 'keywords', 'description', 'text'], 'trim'],
            [['enabled'], 'boolean'],
            [['enabled'], 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => Yii::t('app', 'Slug'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'enabled' => Yii::t('app', 'Enabled'),
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
            'text' => Yii::t('app', 'Text'),
        ];
    }

    /**
     * @return MultilingualQuery|ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->id == 1) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
}