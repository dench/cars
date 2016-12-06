<?php
/** @var $this yii\web\View */
/** @var $timeline */

use app\assets\PahoAsset;
use yii\helpers\Url;

$url = Url::to(['game/start']);
$url_cameraY = Url::to(['game/camera-y']);
$from = @$timeline['from']+0;
$id = @$timeline['id']+0;

$mqttServer = Yii::$app->params['mqttServer'];
$mqttPort = Yii::$app->params['mqttPort'];

$js = <<<JS
var client;
var timeinterval;
var config;
updateClock();

function updateClock() {
    if (!timeinterval) {
        timeinterval = setInterval(updateClock, 1000);
    }
    var t = getTimeRemaining({$from});
    if (t.total > 0) {
        $('.camarea-info').show();
        $('.camarea .minutes').text(t.minutes);
        $('.camarea .seconds').text(t.seconds);
    } else {
        clearInterval(timeinterval);
        $('.camarea-info').hide();
        if ($id) {
            $.post('{$url}', { id: {$id} }, function(e) {
                config = e;
                console.log(config);
                if (e.status == 'Ok #match') {
                    connectRobot();
                } else if (e.status == 'Ok #reboot') {
                    progress();
                    setTimeout(connectRobot, 40000);
                } else {
                    mqttStatus(2);
                }
            }, 'json');
        }
    }
}

function connectRobot() {
    $('.camarea-view').attr('src', config.url);
    $('.progress').val($('.progress').attr('max'));
    client = new Paho.MQTT.Client("{$mqttServer}", {$mqttPort}, "web_" + parseInt(Math.random() * 100, 10));
    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;
    var options = {
        useSSL: false,
        userName: config.id.toString(),
        password: config.password,
        onSuccess: onConnect,
        onFailure: doFail
    }
    client.connect(options);
}

function onConnect() {
    console.log("onConnect");
    mqttStatus(1);
    var message = new Paho.MQTT.Message(config.user);
    message.destinationName = "connected";
    client.send(message);
    gameLoop();
}

function mqttStatus(status) {
    $('.mqtt-status div').hide();
    if (status == 0) {
        $('.mqtt-loading').show();
    }
    if (status == 1) {
        $('.mqtt-connected').show();
    }
    if (status == 2) {
        $('.mqtt-disconnect').show();
    }
}

function doFail(e){
    console.log(e);
}

function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        console.log("onConnectionLost:"+responseObject.errorMessage);
    }
}

function onMessageArrived(message) {
    console.log(message.payloadString);
}

function send(data) {
    message = new Paho.MQTT.Message(data);
    message.destinationName = config.zone+"/"+config.robot+"/";
    client.send(message);
}

function progress() {
    var obj = $('.progress');
    obj.val(obj.val()+1);
    if (obj.val() < obj.attr('max')) {
        obj.show();
        setTimeout(progress, 40);
    } else {
        obj.hide();
    }
}

function getTimeRemaining(endtime) {
    var t = endtime - Math.floor(new Date()/1000);
    var seconds = Math.floor( (t) % 60 );
    var minutes = Math.floor( (t/60) % 60 );
    var hours = Math.floor( (t/(60*60)) % 24 );
    var days = Math.floor( t/(60*60*24) );
    return {
        'total': t,
        'days': days,
        'hours': hours,
        'minutes': minutes,
        'seconds': seconds
    };
}
JS;

$control = <<<JS
var m_up = '00';
var m_down = '88';
var m_left = '17';
var m_right = '71';
var m_stop = '44';

var m_up_left = '03';
var m_up_right = '30';
var m_down_left = '58';
var m_down_right = '85';

var motor = m_stop;
var camera_x = 4; // 1,2,3,4,5,6,7 - 4 center, 0 calibrate
var camera_y = 2; // 1,2,3 - 2 center
var camera_posY = 1;
var camera_posX = 1;

var key_up = 38;
var key_down = 40;
var key_left = 37;
var key_right = 39;

var key_c_up = 104;
var key_c_down = 98;
var key_c_left = 100;
var key_c_right = 102;
var key_c_home = 101;
var key_c_calibrate = 105;

var ms = 500;
var ms2 = 1500;
var ms3 = 800;

var timer1;
var timer2;
var timer3;

var keyPressed = {};

document.addEventListener('keydown', function(e) {
   keyPressed[e.keyCode] = true;
   switch (event.keyCode) {
        case key_up: document.getElementById('s_up').classList.add('active'); break;
        case key_down: document.getElementById('s_down').classList.add('active'); break;
        case key_left: document.getElementById('s_left').classList.add('active'); break;
        case key_right: document.getElementById('s_right').classList.add('active'); break;
        case key_c_up: document.getElementById('c_up').classList.add('active'); break;
        case key_c_down: document.getElementById('c_down').classList.add('active'); break;
        case key_c_left: document.getElementById('c_left').classList.add('active'); break;
        case key_c_right: document.getElementById('c_right').classList.add('active'); break;
        case key_c_home: document.getElementById('c_home').classList.add('active'); break;
        case key_c_calibrate: document.getElementById('c_calibrate').classList.add('active'); break;
    }
}, false);
document.addEventListener('keyup', function(e) {
   keyPressed[e.keyCode] = false;
   switch (event.keyCode) {
        case key_up: document.getElementById('s_up').classList.remove('active'); break;
        case key_down: document.getElementById('s_down').classList.remove('active'); break;
        case key_left: document.getElementById('s_left').classList.remove('active'); break;
        case key_right: document.getElementById('s_right').classList.remove('active'); break;
        case key_c_up: document.getElementById('c_up').classList.remove('active'); break;
        case key_c_down: document.getElementById('c_down').classList.remove('active'); break;
        case key_c_left: document.getElementById('c_left').classList.remove('active'); break;
        case key_c_right: document.getElementById('c_right').classList.remove('active'); break;
        case key_c_home: document.getElementById('c_home').classList.remove('active'); break;
        case key_c_calibrate: document.getElementById('c_calibrate').classList.remove('active'); break;
    }
}, false);

function gameLoop()
{
    if (keyPressed[key_up] && keyPressed[key_left]) {
        motor_set(m_up_left);
    } else if (keyPressed[key_up] && keyPressed[key_right]) {
        motor_set(m_up_right);
    } else if (keyPressed[key_down] && keyPressed[key_left]) {
        motor_set(m_down_right);
    } else if (keyPressed[key_down] && keyPressed[key_right]) {
        motor_set(m_down_left);
    } else if (keyPressed[key_up]) {
        motor_set(m_up);
    } else if (keyPressed[key_down]) {
        motor_set(m_down);
    } else if (keyPressed[key_left]) {
        motor_set(m_left);
    } else if (keyPressed[key_right]) {
        motor_set(m_right);
    } else {
        motor_set(m_stop);
    }
    if (keyPressed[key_c_left]) {
        camera_left();
    } else if (keyPressed[key_c_right]) {
        camera_right();
    } else if (keyPressed[key_c_home]) {
        camera_home();
    } else if (keyPressed[key_c_calibrate]) {
        camera_calibrate();
    } else if (keyPressed[key_c_up]) {
        camera_up();
    } else if (keyPressed[key_c_down]) {
        camera_down();
    }
    setTimeout(gameLoop, 5);
}

function motor_set(m) {
    if (motor != m) {
        clearTimeout(timer1);
        motor = m;
        send_motor(motor);
        timer1 = setTimeout(function() {
            motor = m_stop;
        }, ms);
    }
}

function cameraX() {
    clearTimeout(timer2);
    camera_posX = 0;
    send_cameraX(camera_x);
    timer2 = setTimeout(function() {
        camera_posX = 1;
        if (!camera_x) {
            camera_x = 4;
        }
    }, ms2);
}

function cameraY() {
    clearTimeout(timer3);
    camera_posY = 0;
    send_cameraY(camera_y);
    timer3 = setTimeout(function() {
        camera_posY = 1;
        if (!camera_y) {
            camera_y = 2;
        }
    }, ms3);
}

function camera_left() {
    if (camera_x > 1 && camera_posX) {
        camera_x = camera_x-1;
        cameraX();
    }
}

function camera_right() {
    if (camera_x < 7 && camera_posX) {
        camera_x = camera_x+1;
        cameraX();
    }
}

function camera_up() {
    if (camera_y < 3 && camera_posY) {
        camera_y = camera_y+1;
        cameraY();
    }
}

function camera_down() {
    if (camera_y > 1 && camera_posY) {
        camera_y = camera_y-1;
        cameraY();
    }
}

function camera_home() {
    if (camera_x != 4) {
        camera_x = 4;
        cameraX();
    }
    if (camera_y != 2) {
        camera_y = 2;
        cameraY();
    }
}

function camera_calibrate() {
    if (camera_x != 0) {
        camera_x = 0;
        cameraX();
    }
}

function send_motor(val) {
    console.log("m=" + val);
    send("m=" + val);
}

function send_cameraX(val) {
    console.log("c=" + val);
    send("c=" + val);
}

function send_cameraY(val) {
    console.log("y=" + val);
    $.post('{$url_cameraY}', {
        val: val,
        robot: config.robot,
    });
}
JS;


PahoAsset::register($this);

$this->registerJs($js);
$this->registerJs($control);
?>

<div class="camarea">
    <div class="camarea-info">Игра начнется в <?= Yii::$app->formatter->asTime($timeline['from']) ?><br>через <span class="minutes">0</span> мин <span class="seconds">0</span> сек</div>
    <img src="/img/camarea_none.jpg" alt="Game View" class="camarea-view" width="640" height="480">
    <progress class="progress progress-warning" value="0" max="1000" style="display: none;"></progress>
    <div class="mqtt-status">
        <div class="mqtt-loading"><?= Yii::t('app', 'Loading') ?></div>
        <div class="mqtt-connected"><?= Yii::t('app', 'Connected') ?></div>
        <div class="mqtt-disconnect"><?= Yii::t('app', 'Disconnect') ?></div>
    </div>
</div>

<div id="signal">
    <i id="s_up"></i>
    <i id="s_down"></i>
    <i id="s_left"></i>
    <i id="s_right"></i>
    <i id="c_up"></i>
    <i id="c_down"></i>
    <i id="c_left"></i>
    <i id="c_right"></i>
    <i id="c_home"></i>
    <i id="c_calibrate"></i>
</div>
<div id="keys">
    <i id="left"></i>
    <i id="right"></i>
    <i id="up"></i>
    <i id="down"></i>
</div>

