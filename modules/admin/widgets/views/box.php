<?php

?>
<div class="box box-default">
    <?php if ($title) : ?>
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title ?></h3>
    </div>
    <?php endif; ?>
    <div class="box-body">
        <?= $body ?>
    </div>
    <?php if ($footer) : ?>
    <div class="box-footer">
        <?= $footer ?>
    </div>
    <?php endif; ?>
</div>