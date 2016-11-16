<?php
/* @var $this yii\web\View */

$js = <<<JS
$('#nowline').each(function(){
    var h = $(this).next().height();
    var w = $(this).next().width();
    $(this).height(h+2).css({marginLeft: w/2});
});
var order = [];
$('#timeline td').click(function() {
    var cls = 'selected';
    var time = $(this).attr('data-time');
    if ($(this).hasClass(cls)) {
        $(this).removeClass(cls);
        order.splice(order.indexOf(parseInt(time)),1);
    } else {
        $(this).addClass(cls);
        order.push(parseInt(time));
    }
    timeFromTo(order.slice());
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
        $('#fromto').append($('<input>').attr('name', 'Timeline['+i+']from').attr('type', 'hidden').val(from[i]));
        $('#fromto').append($('<input>').attr('name', 'Timeline['+i+']to').attr('type', 'hidden').val(to[i]));
    }
}
JS;

$this->registerJs($js);

$time = time();
$mktime = mktime(0, 0, 0);
?>

<div class="table-responsive table-timeline-wrap">
    <div id="nowline"></div>
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
                if ($j % 2) $class = " class=\"even\""; else $class = "";
                echo "<td" . $class . " data-time=\"" . $t . "\" title=\"" . Yii::$app->formatter->asDatetime($t) . "\">30</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</div>
<form id="fromto" method="post">
</form>