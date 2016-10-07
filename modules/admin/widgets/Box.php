<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 05.07.16
 * Time: 16:06
 */

namespace app\modules\admin\widgets;

use yii\bootstrap\Widget;

class Box extends Widget
{
    public $title;

    public $footer;
    
    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run()
    {
        return $this->render('box', [
            'body' => ob_get_clean(),
            'title' => $this->title,
            'footer' => $this->footer,
        ]);
    }
}