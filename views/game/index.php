<?php
/** @var $this yii\web\View */
/** @var $timeline */

//use app\models\Robot;
use yii\helpers\Url;

$url = Url::to(['game/start']);
$from = @$timeline['from']+0;
$id = @$timeline['id']+0;

$js = <<<JS
var timeinterval;
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
            $.post('{$url}', { id: {$id} }, function(data) {
                console.log(data);
            }, 'json');
        }
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

$this->registerJs($js);

/*$robot = Robot::findOne(2);
$data['user'] = "dench";
$data['password'] = "12345";

$url = $robot->address."/set_users.cgi?loginuse=admin&loginpas=rclink&user1=&pwd1=&pri1=1&user2=".$data['user']."&pwd2=".$data['password']."&pri2=2&user3=admin&pwd3=rclink&pri3=255";

$result = file_get_contents($url);

if (strpos($result, '"ok"')) {
    $url = $robot->address."/reboot.cgi?user=admin&pwd=rclink";
    $result = file_get_contents($url);
    if (strpos($result, '"ok"')) {
        echo "OK";
    }
}*/
?>

<div class="camarea">
    <div class="camarea-info">Игра начнется в <?= Yii::$app->formatter->asTime($timeline['from']) ?><br>через <span class="minutes">0</span> мин <span class="seconds">0</span> сек</div>
    <img src="/img/camarea_none.jpg" alt="Game Area" class="camarea-view">
</div>

