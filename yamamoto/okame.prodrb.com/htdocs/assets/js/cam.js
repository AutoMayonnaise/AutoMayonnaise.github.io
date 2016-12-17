$(function() {
	//videoタグを取得
	var video = document.getElementById('camera');
	//カメラが起動できたかのフラグ
	var localMediaStream = null;
	//カメラ使えるかチェック
	var hasGetUserMedia = function() {
		return (navigator.getUserMedia || navigator.webkitGetUserMedia ||
			navigator.mozGetUserMedia || navigator.msGetUserMedia);
	};

	//エラー
	var onFailSoHard = function(e) {
		console.log('エラー!', e);
	};

	if(!hasGetUserMedia()) {
		alert("未対応ブラウザです。");
	} else {
		window.URL = window.URL || window.webkitURL;
		navigator.getUserMedia  = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
		navigator.getUserMedia({video: true}, function(stream) {
			video.src = window.URL.createObjectURL(stream);
			localMediaStream = stream;
		}, onFailSoHard);
	}
	

	$("#start").click(function() {
		if (localMediaStream) {

			// アニメーションを再生
			$('.roulette').css('display', 'block');

			// アニメ以外の要素を非表示にする
			//$('.relative').css('display', 'none');


			var canvas = document.getElementById('canvas');
			//canvasの描画モードを2sに
			var ctx = canvas.getContext('2d');
			var img = document.getElementById('imgs');

			//videoの縦幅横幅を取得
			var w = video.offsetWidth;
			var h = video.offsetHeight;

			//同じサイズをcanvasに指定
			canvas.setAttribute("width", w);
			canvas.setAttribute("height", h);

			//canvasにコピー
			ctx.drawImage(video, 0, 0, w, h);
			//imgにpng形式で書き出し
			img.src = canvas.toDataURL('image/png');
			
			
			// Test
			
			// body部パラメーター
		    var data = {};
		    // Canvasのデータをbase64でエンコードした文字列を取得
		   var canvasData = $('canvas').get(0).toDataURL();

		    // 不要な情報を取り除く
		    canvasData = canvasData.replace(/^data:image\/png;base64,/, '');

		   data.image = canvasData;

		    $.ajax({
		        url: '/ajax/strage.php',
		        type: 'POST',
		        data:data,
		        dataType: 'text',
		        success: function(data) {
		            // 成功時の処理
		            decode_data = data.split('~'); // decode_data[1]に結果が文字列で返ってくる
					result = $.parseJSON(decode_data[1]);


					switch(result.id) {
						case 1:
							document.location.href = "result_mayo.html";
							break;
						case 2:
							document.location.href = "resultOk_docter.html";
							break;
						case 3:
							document.location.href = "resultNg_docter.html";
							break;
						default:
							document.location.href = "result_mom.html";
							break;
					}

		            //document.location.href = "recognition.php";
					//console.log(data);

					// アニメーションの停止
					$('.anime').css('display', 'none');


		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		            // 失敗時の処理
		            console.log("error");
		            console.log(jqXHR);
		            console.log(jqXHR.status);
		            console.log(textStatus);
		            console.log(errorThrown);
					$('.anime').css('display', 'none');

				}
		    });
			
			
			
			
			
		}
	});
});