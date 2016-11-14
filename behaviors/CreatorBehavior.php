<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 05.07.16
 * Time: 11:36
 */

namespace app\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class CreatorBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive user_id value
     */
    public $userIdAttribute = 'user_id';

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
            BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->userIdAttribute],
        ];
    }

    /**
     * @inheritdoc
     *
     * In case, when the [[value]] is `null`, the result of the Yii::$app->user->id
     * will be used as value.
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            return Yii::$app->user->id;
        }
        return parent::getValue($event);
    }
}