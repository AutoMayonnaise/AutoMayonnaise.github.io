<?php

require_once dirname(dirname(__FILE__)) . '/system/common.inc.php';

$api = new api();

//GoogleAPI���g���ė������擾
$ans = $api->getDishName();

$twig->assign('ans', $ans);
echo $twig->fetch('__success.html');
exit;
