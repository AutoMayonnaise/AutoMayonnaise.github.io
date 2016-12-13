<?php

require_once dirname(dirname(__FILE__)) . '/system/common.inc.php';

$api = new api();

//GoogleAPI‚ðŽg‚Á‚Ä—¿—–¼Žæ“¾
$ans = $api->getDishName();

$twig->assign('ans', $ans);
echo $twig->fetch('__success.html');
exit;
