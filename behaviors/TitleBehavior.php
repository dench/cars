<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 05.07.16
 * Time: 12:25
 */

namespace app\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class TitleBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive title value
     */
    public $titleAttribute = 'title';

    /**
     * @var string the attribute that will receive title value
     */
    public $nameAttribute = 'name';

    /**
     * @inheritdoc
     */
    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->attributes = [
            BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->titleAttribute],
            BaseActiveRecord::EVENT_BEFORE_UPDATE => [$this->titleAttribute],
        ];
    }

    /**
     * @inheritdoc
     *
     * In case, when the `title` is `empty`, the result of the `name`
     * will be used as value.
     */
    protected function getValue($event)
    {
        $title = $this->owner->{$this->titleAttribute};

        if (empty($title)) {
            return $this->owner->{$this->nameAttribute};
        } else {
            return $title;
        }
    }
}