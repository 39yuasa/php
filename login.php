<?php
    session_start();
    include("dbconnect.php");

    if( !empty( $_POST) ){
        if( $_POST["user"] != "" && $_POST["pass"] != "" ){
            $user = $_POST["user"];
            $pass = $_POST["pass"];

            $sql ="SELECT * FROM users WHERE name='{$user}' AND password='{$pass}'";
            $rst = mysqli_query( $con, $sql );

            if( $row = mysqli_fetch_assoc( $rst )){
                $_SESSION['userid'] = $row['id'];
                //DBのbbsテーブルのu_idに格納されるもの
                $_SESSION['username'] = $row['user'];
                //echo $row["user"]."さん、ログイン出来ます。";

                header('Location: bbs.php' );
                exit();
            }
            else {
                echo "ログインできません。";
            }
            mysqli_free_result( $rst );
        }
    mysqli_close( $con );
    }
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
    <h2>ログイン</h2>
    <form method="post" action="">
        <p>ユーザ名：<input type="text" name="user"></p>
        <p>パスワード：<input type="password" name="pass"></p>
        <input type="submit" name="sub" value="ログイン">
    </form>

    <p>新規ユーザ登録の方は、こちらからどうぞ。</p>
    <p><a href="newuser.php">新規登録</a></p>
</body>
</html>