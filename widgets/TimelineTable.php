<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 18.11.16
 * Time: 18:36
 */

namespace app\widgets;

use app\models\Robot;
use yii\base\Widget;

class TimelineTable extends Widget
{
    public $zone_id;

    public function run()
    {
        return $this->render('timeline-table', [
            'count' => Robot::countRobots(['zone_id' => $this->zone_id])
        ]);
    }
}