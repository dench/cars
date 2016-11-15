<?php

/* @var $this yii\web\View */

use app\widgets\H1;

?>

<?= H1::run($this->params['page']->name); ?>

<?= H1::run($this->params['page']->text); ?>

<?php
/*
$login = 'admin';
$password = 'admin';
$url = 'http://192.168.1.201:8080/tmpfs/auto.jpg';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
$result = curl_exec($ch);
curl_close($ch);
$filename = time() . '.jpg';
file_put_contents($filename, $result);
*/