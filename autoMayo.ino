int light=0;
int count=0;
int inputval=0;
int change=0;

void setup(){
  pinMode(1,OUTPUT); //信号用ピン
  pinMode(2,OUTPUT); //信号用ピン

// シリアルポートを9600 bps[ビット/秒]で初期化 
  Serial.begin(9600);
  
  pinMode(8,OUTPUT) ;   // LED接続のピン(13番)をデジタル出力に設定
 
}

void loop(){

  digitalWrite(8, HIGH) ;  // LEDを点灯(HIGH（5V）)で出力
  int ans;
  ans = analogRead(5) ;  // CDS接続のアナログピン０番を読み取る

  //Serial.println(ans);

  // シリアルポートより1文字読み込む
  byte val;
  // シリアルポートより1文字読み込む
  val=Serial.read();
  int a=val-48;//48は魔法の数字
  if((a>0)&&(a<10)){
    count=a;
    
  }else if(count==0){ //ここがあってるのかはわからん
      count=0;
  }
 if (ans >= 500) {      // 500がしきい値です
        
      if(light==1)light=0;

     } else {
          
       if(light==0)light=1;
     }
Serial.println(count);
     if (light==0) {      // 500がしきい値です
        // 光がしきい値より暗く(大きく)なったなら処理

         if(count==0){
            digitalWrite(1,LOW);
            digitalWrite(2,LOW);
            //valが大きいほど出力値も大きくなる
            analogWrite(3,0); //出力値:1~255
            delay(100);
            count=0;
          }else if(count>0){
            digitalWrite(1,HIGH);
            digitalWrite(2,LOW);
            //valが大きいほど出力値も大きくなる
            analogWrite(3,255); //出力値:1~255
            delay(500);//とりがーから脱する
            Serial.println(count);
            count--;
          }else{
            count=0;
            }
delay(1000);
     } else {
           // 光がしきい値より明るく(小さく)なったなら処理
         digitalWrite(1,HIGH);
         digitalWrite(2,LOW);
         //valが大きいほど出力値も大きくなる
         analogWrite(3,255); //出力値:1~255
         delay(100);
     }


}
