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
    if ($(this).hasClass(cls)) {
        $(this).removeClass(cls);
    } else {
        $(this).addClass(cls);
    }
});
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
                echo "<td" . $class . " rel=\"" . $t . "\" title=\"" . Yii::$app->formatter->asDate($t, 'php:d.m.Y, H:i') . "\">30</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</div>