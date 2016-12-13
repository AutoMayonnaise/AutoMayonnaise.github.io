void setup(){
  pinMode(1,OUTPUT); //信号用ピン
  pinMode(2,OUTPUT); //信号用ピン

// シリアルポートを9600 bps[ビット/秒]で初期化 
  Serial.begin(9600);
 
}

void loop(){
  
  // シリアルポートより1文字読み込む
  byte val;
  // シリアルポートより1文字読み込む
  val=Serial.read();
  int a=val-48;//48は魔法の数字
  
  Serial.println(a);
  
  if((a>0)&&(a<10)){
   digitalWrite(1,HIGH);
    digitalWrite(2,LOW);
    //valが大きいほど出力値も大きくなる
    analogWrite(3,100); //出力値:1~255
    int time=a*1000;
    delay(time);
  }else{
    digitalWrite(1,LOW);
    digitalWrite(2,LOW);
    //valが大きいほど出力値も大きくなる
    analogWrite(3,0); //出力値:1~255
    delay(1000);
    }

}
