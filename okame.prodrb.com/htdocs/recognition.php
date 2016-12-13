<?php

require_once dirname(dirname(__FILE__)) . '/system/common.inc.php';

$api = new api();
$mayonnaise = new mayonnaise();

$dish = array();

//GoogleAPIを使って料理名取得
$ans = $api->getDishName();

//APIの結果から必要な部分だけ取得
$result_api = $api->resultApi($ans["json"]);

//結果から「えびせん」「チョコレート」「error」のどれか判断
$dish[] = $mayonnaise->choose_name($result_api);

//カロリー計算
$ans_dish = $mayonnaise->all_calorie($dish);

//マヨネーズかける処理
$test = $mayonnaise->decisionMayo($ans_dish);


$twig->assign('test', $test);
echo $twig->fetch('__result.html');
exit;
