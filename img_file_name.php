<?php
//ファイルアップロード用関数
//使用例　　$img = img_file_name();
function img_file_name(){
    $f = "uploadfile"; //　画像投稿した時のinputタグ名
    $dir = "upload/"; //保存するディレクトリ名
    $img = ""; //アップロードしたファイルのサーバ側でのファイル名

    if( $_FILES[$f]['name'] == "") //アップロードのファイルが無いとき空文字をreturnする
        return $img;

    //拡張子の決定
    $ext = "";
    if( $_FILES[$f]['type'] == 'image/gif' )
        $ext = 'gif';
    else if( $_FILES[$f]['type'] == 'image/pjpeg' || $_FILES[$f]['type'] == 'image/jpeg')
        $ext = 'jpg';
    
    if( $ext == "" ){
        exit("指定の形式ではないので登録できません。");
    }
    else {
        $imgname = date("Ymd-His")."-".rand(1000,9999).".".$ext;//重複名にならないように現在の時間と乱数で命名
        if( move_uploaded_file( $_FILES[$f]['tmp_name'], $dir.$imgname)){
            $img = $imgname;
        }
        else {
            exit("画像ファイルのアップロードに失敗しました。");
        }
    }
    return $img;
}