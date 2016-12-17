<?php

require_once dirname(dirname(dirname(__FILE__))) . '/system/common.inc.php';

    $imageData = $_POST['image'];

    echo $_POST['image'];

    $filename = './example.png';
    $fp = fopen($filename, 'w+');
    fwrite($fp,base64_decode($imageData));

    $html = "OK";

   // header('Content-type: application/json');//指定されたデータタイプに応じたヘッダーを出力する
  $ans = ["status"=>"OK"];
   //echo json_encode( $ans );



    $api = new api();
    $mayonnaise = new mayonnaise();

    $dish = array();

    //GoogleAPI
    $ans = $api->getDishName();

    //APIのひつようなところだけ取得
    $result_api = $api->resultApi($ans["json"]);

    //料理名決定
    $dish[] = $mayonnaise->choose_name($result_api);

    //総カロリー計算
    $ans_dish = $mayonnaise->all_calorie($dish);

    //キャラ決定
    $test = $mayonnaise->decisionMayo($ans_dish);



echo "~" . json_encode($test);


   
   
    