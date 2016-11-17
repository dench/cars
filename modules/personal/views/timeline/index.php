<?php
/** @var $this yii\web\View */
/** @var $from array */
/** @var $count integer */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$js = <<<JS
var order = [];
$('#timeline td.free').click(function() {
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
    $('#fromto div').empty();
    for (i = 0; i < from.length; i++) {
        $('#fromto div').append($('<input>').attr('name', 'Timeline['+i+'][from]').attr('type', 'hidden').val(from[i]));
        $('#fromto div').append($('<input>').attr('name', 'Timeline['+i+'][to]').attr('type', 'hidden').val(to[i]));
    }
    if (from.length) {
        $('#fromto button').prop('disabled', false);
    } else {
        $('#fromto button').prop('disabled', true);
    }
}
JS;

$this->registerJs($js);

$time = time();
$mktime = mktime(0, 0, 0);
?>

<div class="table-responsive table-timeline-wrap">
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

                if ($t < $time) {
                    $icon = "";
                    $text = Yii::t('app', 'Passed');
                } else {
                    $icon = "square-o";
                    $text = Yii::t('app', 'Free');
                    if (isset($from[$t]) && $from[$t] >= $count) {
                        $class .= " busy";
                        $icon = "times";
                        $text = Yii::t('app', 'Busy');
                    } else {
                        $class .= " free";
                    }
                }
                echo "<td class=\"" . $class . "\" data-time=\"" . $t . "\" title=\"" . Yii::$app->formatter->asDatetime($t) . " (" . $text . ")\"><i class=\"fa fa-".$icon."\"></i></td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</div>

<?php $form = ActiveForm::begin(['id' => 'fromto']); ?>
    <div></div>
    <?= Html::submitButton(Yii::t('app', 'Reserve'), ['class' => 'btn btn-primary btn-lg', 'disabled' => true]) ?>
<?php ActiveForm::end(); ?>