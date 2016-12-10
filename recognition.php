<?php

print<<<EOF
	<!DOCTYPE html>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="css/style.css">
		<title>Webカメラの映像を画像化</title>
	</head>
	<body>
		<img id="img" src="example.png">
EOF;


$ch = curl_init();

	// APIキー
	$api_key = "AIzaSyCyGePNkWsO7eQTvzqLyynV6Gzc4OuA54A";

	// リファラー (許可するリファラーを設定した場合)
	//$referer = "https://...com/" ;

	// 画像へのパス
	//パスはexample.pngに変更
	$image_path = "image/test.jpg" ;

	// リクエスト用のJSONを作成
	$json = json_encode( array(
		"requests" => array(
			array(
				"image" => array(
					"content" => base64_encode( file_get_contents( $image_path ) ) ,
				) ,
				"features" => array(
					array(
						"type" => "LABEL_DETECTION" , //LABEL_DETECTION:カテゴリの検出 
						"maxResults" => 3 , //ポイントの高いものから順に表示
					) ,
				) ,
			) ,
		) ,
	) ) ;

	echo $json ;

	// リクエストを実行
	$curl = curl_init() ;
	curl_setopt( $curl, CURLOPT_URL, "https://vision.googleapis.com/v1/images:annotate?key=" . $api_key ) ;
	curl_setopt( $curl, CURLOPT_HEADER, true ) ; 
	curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "POST" ) ;
	curl_setopt( $curl, CURLOPT_HTTPHEADER, array( "Content-Type: application/json" ) ) ;
	curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false ) ;
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true ) ;
	//if( isset($referer) && !empty($referer) ) curl_setopt( $curl, CURLOPT_REFERER, $referer ) ;
	curl_setopt( $curl, CURLOPT_TIMEOUT, 15 ) ;
	curl_setopt( $curl, CURLOPT_POSTFIELDS, $json ) ;
	$res1 = curl_exec( $curl ) ;
	$res2 = curl_getinfo( $curl ) ;
	curl_close( $curl ) ;

	// 取得したデータ
	$json = substr( $res1, $res2["header_size"] ) ;				// 取得したJSON
	$header = substr( $res1, 0, $res2["header_size"] ) ;		// レスポンスヘッダー

	// 出力
	echo "<h2>JSON</h2>" ;
	echo $json ;

	echo "<h2>ヘッダー</h2>" ;
	echo $header ;
	

print<<<EOF
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="js/cam.js"></script>
	</body>
	</html>
EOF;
	
?>	