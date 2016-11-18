<?php
/** @var $this yii\web\View */
/** @var $count integer */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
});
$('[data-toggle="tooltip"]').tooltip();
timelineUp();
setInterval(function() {
    timelineUp();
}, 5000);

function timelineUp() {
    $.post('{$url}', function(data){
        $('#timeline td').removeClass('passed').removeClass('busy').removeClass('me').addClass('free');
        for (var key in data.busy) {
            $('td[data-time="'+key+'"]').removeClass('free').addClass('busy');
        }
        for (key in data.passed) {
            $('td[data-time="'+key+'"]').removeClass('free').addClass('passed');
        }
        for (key in data.me) {
            $('td[data-time="'+key+'"]').addClass('me');
        }
    });
}

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
                echo "<td class=\"" . $class . "\" data-toggle=\"tooltip\" data-placement=\"top\" data-time=\"" . $t . "\" title=\"" . Yii::$app->formatter->asDatetime($t) . "\"></td>";
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