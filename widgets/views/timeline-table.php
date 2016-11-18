<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 18.11.16
 * Time: 18:37
 */

use yii\helpers\Url;

$url = Url::to(['reserved']);

$js = <<<JS
var order = [];
$('#timeline').find('td').click(function() {
    if (!$(this).hasClass('free') || $(this).hasClass('me')) return;
    var cls = 'selected';
    var time = $(this).attr('data-time');
    if ($(this).hasClass(cls)) {
        $(this).removeClass(cls).find('i').removeClass('fa-check-square-o').addClass('fa-square-o');
        order.splice(order.indexOf(parseInt(time)),1);
    } else {
        $(this).addClass(cls).find('i').removeClass('fa-square-o').addClass('fa-check-square-o');
        order.push(parseInt(time));
    }
    timeFromTo(order.slice());
}).tooltip({
    html: true,
    placement: 'top'
});

function timeFromTo(all) {
    all.sort(function(a,b){return a-b;});
    var from = [];
    var to = [];
    var k = 1;
    var j = 0;
    if (all[0] != null) {
        from[j] = all[0];
    }
    for (var i = 1; i < all.length; i++) {
        if (from[j]+30*60*k != all[i]) {
            to[j] = from[j]+30*60*k;
            j++;
            from[j] = all[i];
            k = 0;
        }
        k++;
    }
    if (all[0] != null) {
        to.push(all.pop()+30*60);
    }
    $('#fromto').empty();
    for (i = 0; i < from.length; i++) {
        $('#fromto').append($('<input>').attr('name', 'Timeline['+i+'][from]').attr('type', 'hidden').val(from[i]));
        $('#fromto').append($('<input>').attr('name', 'Timeline['+i+'][to]').attr('type', 'hidden').val(to[i]));
    }
    if (from.length) {
        $('#fromto').parent().find('button').prop('disabled', false);
    } else {
        $('#fromto').parent().find('button').prop('disabled', true);
    }
}

timelineUp();
setInterval(function() {
    timelineUp();
}, 5000);

function timelineUp() {
    $.post('{$url}', function(data){
        $('#timeline td').removeClass('passed').removeClass('busy').removeClass('me').addClass('free').each(function(){
            var temp = $(this).attr('data-original-title').split('<br>');
            $(this).attr('data-original-title', temp[0]+'<br>(Free)');
        });
        var obj;
        var temp;
        for (var key in data.busy) {
            obj = $('td[data-time="'+key+'"]');
            temp = obj.attr('data-original-title').split('<br>');
            if (data.busy[key] >= {$count}) {
                obj.removeClass('free').addClass('busy').attr('data-original-title', temp[0]+'<br>(All reserved)');
            } else {
                obj.attr('data-original-title', temp[0]+'<br>(Free, reserved '+data.busy[key]+' of {$count})');
            }
        }
        for (key in data.passed) {
            obj = $('td[data-time="'+key+'"]');
            temp = obj.attr('data-original-title').split('<br>');
            obj.removeClass('free').addClass('passed').attr('data-original-title', temp[0]+'<br>(Passed)');
        }
        for (key in data.me) {
            obj = $('td[data-time="'+key+'"]');
            temp = obj.attr('data-original-title').split('<br>');
            obj.addClass('me').attr('data-original-title', temp[0]+'<br>(Reserved for you)');
        }
    });
}
JS;

$this->registerJs($js);

$time = time();
$mktime = mktime(0, 0, 0);
?>
<table class="table table-bordered" id="timeline">
    <tr>
        <th class="even"></th>
        <?php
        for ($i = 0; $i < 24; $i++) {
            echo "<th colspan=\"2\" class=\"even\">" . Yii::$app->formatter->asDate($mktime+$i*3600, 'H'). "</th>";
        }
        ?>
    </tr>
    <?php
    for ($i = 0; $i < 7; $i++) {
        echo "<tr>";
        $day = $i*3600*24;
        echo "<th class=\"even\">" . Yii::$app->formatter->asDate($time+$day, 'php:l') . "</th>";
        for ($j = 0; $j < 48; $j++) {
            $t = $mktime+$day+$j*1800;
            if ($j % 2) $class = "even"; else $class = "";
            echo "<td class=\"" . $class . "\" data-time=\"" . $t . "\" title=\"" . Yii::$app->formatter->asDatetime($t) . "<br>\"></td>";
        }
        echo "</tr>";
    }
    ?>
</table>