<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "language".
 *
 * @property string $id
 * @property string $name
 * @property integer $enabled
 */
class Language extends ActiveRecord
{
    private static $_all;

    private static $_list;

    private static $_suffix_list;

    // Переменная, для хранения текущего объекта языка
    public static $current = null;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['enabled'], 'boolean'],
            [['id'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 31],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    /**
     * @return array
     */
    public static function suffixList()
    {
        if (static::$_suffix_list) {
            return static::$_suffix_list;
        }

        $list = static::nameList();

        $_suffix_list[''] = $list[Yii::$app->language];

        unset($list[Yii::$app->language]);

        foreach ($list as $k => $v) {
            $_suffix_list['_' . $k] = $v;
        }

        return $_suffix_list;
    }

    /**
     * @return array
     */
    public static function nameList()
    {
        if (static::$_list) {
            return static::$_list;
        }

        return static::$_list = ArrayHelper::map(self::findModels(), 'id', 'name');
    }

    // Получение текущего объекта языка
    public static function getCurrent()
    {
        if (self::$current === null) {
            self::$current = self::getDefault();
        }
        return self::$current;
    }

    // Установка текущего объекта языка и локаль пользователя
    public static function setCurrent($id = null)
    {
        if ($id) {
            $language = self::findModel($id);
        } else {
            $language = null;
        }
        self::$current = ($language === null) ? self::getDefault() : $language;
        Yii::$app->language = self::$current->id;
    }

    // Получения объекта языка по умолчанию
    public static function getDefault()
    {
        return self::findModel(Yii::$app->sourceLanguage);
    }

    public static function findModel($id)
    {
        if (!self::$_all) {
            self::$_all = self::findModels();
        }

        if (isset(self::$_all[$id])) {
            return self::$_all[$id];
        } else {
            return null;
        }
    }

    public static function findModels()
    {
        if (!self::$_all) {
            self::$_all = self::find()->orderBy('position')->indexBy('id')->all();
        }

        return self::$_all;
    }
}
