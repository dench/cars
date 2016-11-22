<?php
/** @var $this yii\web\View */
/** @var $timeline */
/** @var $from */

$js = <<<JS

var timeinterval;

updateClock();

function updateClock() {
    if (!timeinterval) {
        timeinterval = setInterval(updateClock, 1000);
    }
    var t = getTimeRemaining({$timeline['from']});
    if(t.total) {
        $('.camarea .minutes').text(t.minutes);
        $('.camarea .seconds').text(t.seconds);
    } else {
        clearInterval(timeinterval);
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
?>

<div class="camarea">
    <div class="camarea-info">Игра начнется в <?= Yii::$app->formatter->asTime($timeline['from']) ?><br>через <span class="minutes">0</span> мин <span class="seconds">0</span> сек</div>
    <img src="/img/camarea_none.jpg" alt="Game Area" class="camarea-view">
</div>

