<?php
    session_start();
    include("img_file_name.php");
    include("dbconnect.php");
    $m = "";//投稿された記事群を格納
    $user = $_SESSION["username"];//ログインしたユーザ名

    if( isset( $_POST["sub"] ) ){
        $u_id = $_SESSION["userid"];
        $msg = $_POST["msg"];
        $img = img_file_name(); //画像投稿した際のファイル名(変換済み)

        // bbsテーブルにFormから入力されたデータを追加するSQL文を作成
        $sql = "INSERT INTO bbs ( u_id, msg, date, img)
                VALUES ( '{$u_id}', '{$msg}', now(), '{$img}' )";
        $rst = mysqli_query( $con, $sql );
    }
    //2つのテーブルを結合させて必要なデータを抽出する
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
    <h2>投稿画面</h2>
    <?php
        print "<p>投稿者：".$_SESSION['username']."</p>";
    ?>
    <form method="post" action="" accept-charset="UTF-8" enctype="multipart/form-data">
        <p><textarea name="msg" cols="70" rows="10"></textarea></p>
        画像(GIF/JPEG形式、100KB以下):<input type="file" name="uploadfile" size="40">
        <input type="submit" name="sub" value="投稿">
    </form>

    <?php
        print $m;
    ?>
</body>
</html>