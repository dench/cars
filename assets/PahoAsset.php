<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 06.12.16
 * Time: 13:17
 */

namespace app\assets;

use yii\web\AssetBundle;

class PahoAsset extends AssetBundle
{
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js',
    ];
}