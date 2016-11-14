<?php
namespace app\components;

use Yii;
use app\models\Language;
use yii\web\UrlManager;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if (isset($params['lang_id'])) {
            // Если указан идентификатор языка, то делаем попытку найти язык в БД,
            // иначе работаем с языком по умолчанию
            $lang = Language::findOne($params['lang_id']);
            if ($lang === null) {
                $lang = Language::getDefault();
            }
            unset($params['lang_id']);
        } else {
            // Если не указан параметр языка, то работаем с текущим языком
            $lang = Language::getCurrent();
        }

        // Получаем сформированный URL (без префикса идентификатора языка)
        $url = parent::createUrl($params);

        $url = ($url == '//') ? '/' : $url;

        // Добавляем к URL префикс - буквенный идентификатор языка
        if ($lang->id == Yii::$app->sourceLanguage) {
            return $url;
        } else {
            return '/'.$lang->id.$url;
        }
    }
}