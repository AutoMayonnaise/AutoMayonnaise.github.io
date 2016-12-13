<?php

require_once 'db.inc.php';

//マヨネーズをかけるかかけないか判断
class mayonnaise{
    //マヨ判断テスト用のフォーム処理
    public function test(){
        if (count($_POST) > 0) {
            $name = explode(",",$_POST['text']);
            return $name;
        }
    }

    //デモ用
    //APIから取得した結果からえびせんかチョコか判断
    public function choose_name($dish){
        //結果に'food','chocolate'が含まれていればチョコ
        //結果に'food'しか含まれていなければえびせん
        //それ以外はerrorを返す

        //初期化
        $flag = 0;

        foreach($dish as $value){
            if($value == 'food'){
                $flag = 1;
            }
        }

        if($flag == 1){
            foreach($dish as $value){
                if($value == 'chocolate'){
                    return('チョコレート');
                }
            }
            return('えびせん');
        }else{
            return('error');
        }
    }

    //撮影した料理画像の総カロリーを計算
    public function all_calorie($dish){
        //初期化
        $all_calorie = 0;
        $ans = null;
        $dish_name = null;


        //料理ごとに辞書からカロリー取得
        foreach($dish as $key => $value){

            //DBから料理情報取得
            $info = $this->getCalorie($value);
            //array(4) { ["id"]=> string(1) "1" ["name"]=> string(12) "えびせん" ["calorie"]=> string(1) "5" ["mayo"]=> string(1) "1" }

            //DBに料理が含まれている時の処理
            if($info != false){
                //総カロリーに加算
                $all_calorie += $info["calorie"];
                //マヨネーズをかけるか配列に格納
                $mayo[$key] = $info["mayo"];
            }else{
                //マヨラールートで処理
                foreach($dish as $value){
                    $dish_name .= $value . " ";
                }

                $ans = array(
                    'dish_name' => $dish_name,
                    'all_calorie' => 'error',
                    'mayo' => 'error'
                );
                return($ans);
            }
        }

        foreach($dish as $value){
            $dish_name .= $value . " ";
        }

        $ans = array(
            'dish_name' => $dish_name,
            'all_calorie' => $all_calorie,
            'mayo' => $mayo
        );

        return($ans);
    }

    //マヨネーズかける処理
    public function decisionMayo($ans_dish){
        //初期化
        $character_num = array(1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,3);
        $character = null;
        $amount_mayo = 15;

        if($ans_dish["all_calorie"] != 'error'){
            //総カロリーの計算が正しくできた場合
            //キャラクターのIDをランダムで決定
            //$rand_key：配列の要素番号が格納される
            $rand_key = array_rand($character_num, 1);
            $character = $this->getCharacter($character_num[$rand_key]);

            //キャラクターごとに動作分岐
            switch($character_num[$rand_key]){
                case 1:
                    //マヨラーの処理（かならずマヨネーズをかける）
                    //すべての料理にマヨネーズをかける処理
                    $ans_dish["all_calorie"] = 'カロリーなんて気にすんな！！！！';
                    $test = array(
                        'dish_name' => $ans_dish["dish_name"],
                        'character' => $character["name"],
                        'calorie' => $ans_dish,
                        'mayo' => $character["ratio"],
                        'processing' => '全部にマヨネーズかけるで',
                    );
                    return($test);
                case 2:
                    //健康オタの処理（総カロリー量に合わせてマヨネーズOKの料理にだけマヨネーズをかける）
                    //総カロリー判定
                    if($ans_dish["all_calorie"] < $character["border"]){
                        //マヨネーズかける処理
                        //マヨネーズOKの料理のみにマヨネーズをかける処理
                        $test = array(
                            'dish_name' => $ans_dish["dish_name"],
                            'character' => $character["name"],
                            'calorie' => $ans_dish,
                            'mayo' => $character["ratio"],
                            'processing' => 'マヨOKのやつだけかける',
                        );
                        return($test);

                    }elseif($ans_dish["all_calorie"] >= $character["border"]){
                        //マヨネーズをかけない処理
                        $test = array(
                            'dish_name' => $ans_dish["dish_name"],
                            'character' => $character["name"],
                            'calorie' => $ans_dish,
                            'mayo' => 0,
                            'processing' => 'マヨかけない',
                        );
                        return($test);
                    }
                case 3:
                    //おかんの処理（かならずマヨネーズかけない）
                    $test = array(
                        'dish_name' => $ans_dish["dish_name"],
                        'character' => $character["name"],
                        'calorie' => $ans_dish,
                        'mayo' => 0,
                        'processing' => 'あんたダイエットするって言ってたやろ！マヨネーズやめとき',
                    );
                    return($test);
            }


        }elseif($ans_dish["all_calorie"] == 'error'){
            //総カロリーの計算が正しくできなかった場合
            //キャラクターをマヨラー（フィーバータイプ）に決定
            //マヨラー（フィーバータイプ）：すべての料理にマヨネーズをかける
            $character = $this->getMayora(1);
            //すべての料理にマヨネーズをかける処理
            $ans_dish["all_calorie"] = 'カロリーなんて気にすんな！！！！';
            $test = array(
                'dish_name' => $ans_dish["dish_name"],
                'character' => $character["name"],
                'calorie' => $ans_dish,
                'mayo' => $character["ratio"],
                'processing' => '全部にマヨネーズかけたんで',
            );
            return($test);
        }

    }

    //DBから指定した料理の情報を取得する
    public function getCalorie($name) {
        $sql = "SELECT * FROM `recipes` WHERE `name`=:name";
        $db = PDODatabase::getInstance();
        $dbres = $db->query($sql, array('name'=>$name));
        $dbret = $db->fetch($dbres);
        return($dbret);
    }

    //DBからキャラクターの情報を取得する
    public function getCharacter($id){
        $db = PDODatabase::getInstance();
        $sql = "SELECT * FROM `character` WHERE `id`=:id LIMIT 1";
        $dbres = $db->query($sql, array('id'=>$id));
        $dbret = $db->fetch($dbres);
        return($dbret);
    }

    //DBからマヨラーの情報を取得する
    public function getMayora($id){
        $db = PDODatabase::getInstance();
        $sql = "SELECT * FROM `character` WHERE `id`=:id LIMIT 1";
        $dbres = $db->query($sql, array('id'=>$id));
        $dbret = $db->fetch($dbres);
        return($dbret);
    }
}