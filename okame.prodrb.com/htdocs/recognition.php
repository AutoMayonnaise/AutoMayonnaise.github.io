<?php

require_once dirname(dirname(__FILE__)) . '/system/common.inc.php';

$api = new api();

//GoogleAPIを使って料理名取得
$ans = $api->getDishName();

$twig->assign('ans', $ans);
echo $twig->fetch('__success.html');
exit;
