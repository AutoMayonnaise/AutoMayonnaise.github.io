<?php
$url = "http://192.168.50.130:5000/";

$curl = curl_init($url); // 初期化！

$options = array(           // オプション配列
  //HEADER
  CURLOPT_HTTPHEADER => array(
  ),
  //Method
  CURLOPT_HTTPGET => true,//GET
);

//set options
curl_setopt_array($curl, $options); /// オプション値を設定
// request
$result = curl_exec($curl); // リクエスト実行
//print
echo $result;
?>
