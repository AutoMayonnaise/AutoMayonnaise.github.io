<?php

    $imageData = $_POST['image'];

    $filename = './example.png';
    $fp = fopen($filename, 'w+');
    fwrite($fp,base64_decode($imageData));

    $html = "OK";

    header('Content-type: application/json');//指定されたデータタイプに応じたヘッダーを出力する
    echo json_encode( $ans );






   
   
    