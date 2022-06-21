<?php
    include("dbconnect.php");
    include("img_file_name.php");
    $m = "";

    //ユーザ名の変更
    if( isset( $_POST["movesub"])){
        $old = $_POST["oldname"];
        $new = $_POST["newname"];
    
        //旧ユーザ名がusersテーブルにあるかの？2行くらい
        $sql = "SELECT * FROM users WHERE user='{$old}'";
        $rst = mysqli_query( $con, $sql );

        //旧ユーザ名があったらusersテーブル内の指定されたユーザの名前を変更する
        //if内の{}を含めて5行くらい、UPDATE文を使用する
        if( $row = mysqli_fetch_assoc( $rst ) ){
            $id = $row["id"];
            $sql = "UPDATE users SET name='{$new}' WHERE id='{$id}'";
            $rst = mysqli_query( $con, $sql );
        }
    }
    if( isset( $_POST["delsub"]) ){
        $name = $_POST["delname"];

        $sql = "SELECT * FROM users WHERE name='{$name}'";
        $rst = mysqli_query( $con, $sql );

        if( $row = mysqli_fetch_assoc( $rst ) ){
            $id = $row["id"];
            // usersテーブルから指定のユーザを削除する
            $sql = "DELETE FROM users WHERE id='{$id}'";
            $rst = mysqli_query( $con, $sql );
            // bbsテーブルから指定のユーザが投稿した記事を削除する
            $sql = "DELETE FROM bbs WHERE u_id='{$id}'";
            $rst = mysqli_query( $con, $sql );

        }
    }
    if( isset( $_POST["imgsub"] ) ){
        $cid = $_POST["imgid"];
        $img = img_file_name();

        $sql = "UPDATE bbs SET img='{$img}' WHERE id='{$cid}'";
        $rst = mysqli_query($con, $sql);
    }

    $sql = "SELECT *,bbs.id as b_id, users.name as u_name
    FROM bbs LEFT JOIN users 
    ON bbs.u_id = users.id ORDER BY bbs.id DESC";
    $rst = mysqli_query( $con, $sql );

    while( $row = mysqli_fetch_array( $rst )){
        $m .= "<p>".$row["b_id"]." ";
        $m .= $row["u_name"]." ";
        $m .= $row["date"]."</p>";
        $m .= "<p>".nl2br( $row["msg"])."</p>";
        if( $row["img"] != NULL ){
            $m .= "<p><img src='upload/".$row['img']."' width='20%' height='20%'></p>";
        }
    }
    mysqli_free_result( $rst );
    mysqli_close( $con );

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>管理画面</h1>

    <form method="post" action="" accept-charset="UTF-8" enctype="multipart/form-data">
        <!-- ユーザ名の変更 -->
        <p>ユーザ名の変更</p>
        <p>旧ユーザ名：<input type="text" name="oldname"></p>
        <p>新ユーザ名：<input type="text" name="newname"></p>
        <p><input type="submit" name="movesub" value="変更"></p>

        <!-- ユーザ名の削除 -->
        <p>ユーザ名の削除</p>
        <p>削除するユーザ名：<input type="text" name="delname"></p>
        <p><input type="submit" name="delsub" value="削除"></p>

        <!-- 画像変更 -->
        <p>画像の変更</p>
        <p>画像変更するコメントID：<input type="text" name="imgid"></p>
        <p>画像(GIF/JPEG形式、100KB以下):<input type="file" name="uploadfile" size="40"></p>
        <p><input type="submit" name="imgsub" value="変更"></p>
    </form>
    <?php
        print $m;
    ?>
    
</body>
</html>