<?php

	require_once 'db.inc.php';

	//GoogleAPIで料理名取得
	class api{

		public function getDishName(){
			// APIキー
			$api_key = "AIzaSyCyGePNkWsO7eQTvzqLyynV6Gzc4OuA54A";

			// リファラー (許可するリファラーを設定した場合)
			//$referer = "https://...com/" ;

			// 画像へのパス
			//パスはexample.pngに変更
			$image_path = "http://okame.prodrb.com/ajax/example.png";
//			$image_path = "http://okame.prodrb.com/assets/img/ebisen.JPG";


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
								"maxResults" => 5 , //ポイントの高いものから順に表示
							) ,
						) ,
					) ,
				) ,
			) ) ;

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

			$ans = array(
				'json' => json_decode($json, true),
				'header' => $header
			);

			return($ans);
		}

		//APIの結果から必要な部分だけ取得
		public function resultApi($ans){
			$name = array();
			foreach($ans["responses"][0]["labelAnnotations"] as $key=>$value){
				$name[$key] = $value["description"];
			}

			return($name);
		}
	}