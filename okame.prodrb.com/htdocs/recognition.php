<?php

require_once dirname(dirname(__FILE__)) . '/system/common.inc.php';

$api = new api();
$mayonnaise = new mayonnaise();

$dish = array();

//GoogleAPI
$ans = $api->getDishName();

//APIの結果から必要な箇所だけ取得
$result_api = $api->resultApi($ans["json"]);

//料理名決定
$dish[] = $mayonnaise->choose_name($result_api);

//総カロリー計算
$ans_dish = $mayonnaise->all_calorie($dish);

//キャラクター決定
$test = $mayonnaise->decisionMayo($ans_dish);


$twig->assign('test', $test);
echo $twig->fetch('__result.html');
exit;
