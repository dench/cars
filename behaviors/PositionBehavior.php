<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 05.07.16
 * Time: 12:25
 */

namespace app\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class PositionBehavior extends Behavior
{
    /**
     * @var string the attribute that will receive position value
     */
    public $positionAttribute = 'position';

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
        ];
    }

    public function afterInsert($event)
    {
        /** @var ActiveRecord $owner */
        $owner = $this->owner;

        $owner->{$this->positionAttribute} = $owner->id;
        $owner->save();
    }
}