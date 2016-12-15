void setup() {
  // put your setup code here, to run once:
 pinMode(13, OUTPUT);
   // シリアルポートを9600 bps[ビット/秒]で初期化 
  Serial.begin(9600);
}

void loop() {
  // put your main code here, to run repeatedly:

  int inputchar;
 
  // シリアルポートより1文字読み込む
   delay(1000); 
  inputchar = Serial.read();
  int val = inputchar - 48;
  Serial.print(val,DEC);
  if(inputchar != -1 ){
    // 読み込んだデータが -1 以外の場合　以下の処理を行う
 
    if ( val == 1){
      digitalWrite(13, HIGH);   // turn the LED on (HIGH is the voltage level)
      delay(3000);              // wait for a second
    }
      
    digitalWrite(13, LOW);    // turn the LED off by making the voltage LOW
    delay(1000);              // wait for a second
  }
}
