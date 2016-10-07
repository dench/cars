<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 05.07.16
 * Time: 13:58
 */

namespace app\assets;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/fortawesome/font-awesome';
    
    public $css = [
        'css/font-awesome.min.css'
    ];
}