<?php

require_once dirname(dirname(__FILE__)) . '/system/common.inc.php';

$api = new api();
$mayonnaise = new mayonnaise();

$dish = array();

//GoogleAPI���g���ė������擾
$ans = $api->getDishName();

//API�̌��ʂ���K�v�ȕ��������擾
$result_api = $api->resultApi($ans["json"]);

//���ʂ���u���т���v�u�`���R���[�g�v�uerror�v�̂ǂꂩ���f
$dish[] = $mayonnaise->choose_name($result_api);

//�J�����[�v�Z
$ans_dish = $mayonnaise->all_calorie($dish);

//�}���l�[�Y�����鏈��
$test = $mayonnaise->decisionMayo($ans_dish);


$twig->assign('test', $test);
echo $twig->fetch('__result.html');
exit;
