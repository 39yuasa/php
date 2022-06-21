<?php
    session_start();
    //$error配列内のどのエラーなのかを示すため
    $error['user'] = "";
    $error['pass'] = "";
    //$error['passl'] = "";
    
    if( !empty( $_POST ) ) {
        // エラー項目の確認
        if( $_POST["user"] == "" )
            $error["user"] = "blank";
        if( $_POST["pass"] == "" )
            $error["pass"] = "blank";
        else if( strlen( $_POST["pass"]) < 6 ) // strlen関数は配列内の文字数を返す
            $error["pass"] = "length";

        $judge = array_filter( $error ); //$error配列の中を確認

        if( empty( $judge ) ){ //エラーが無かったら{}内の処理を行う
            $_SESSION["join"] = $_POST; //$_POST全体を$_SESSION['join']に代入
              // $_SESSION['join']['user'] 入力されたユーザ名を確認できる
              // $_SESSION['join']['pass'] 入力されたパスワードを確認できる
            header("Location: check.php");
            exit();
        //     $user = $_POST["user"];
        //     $pass = $_POST["pass"];

        // //   $sql = "INSERT INTO users ( user, password ) VALUES ('{$user}', '{$pass}') ";
        //     $sql = sprintf('INSERT INTO users SET user="%s", password="%s"',
        //                         mysqli_real_escape_string( $con, $user),
        //                         mysqli_real_escape_string( $con, $pass) );
        //     $rst = mysqli_query( $con, $sql );
        }
//        mysqli_close( $con );
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
    <h2>ユーザ登録</h2>
    <form method="post" action="">
        <p>ユーザ名：<input type="text" name="user"></p>
        <?php
            if( $error["user"] == "blank" ):
        ?>
            <p>ユーザ名を入力してください</p>
        <?php
            endif;
        ?>
        <p>パスワード：<input type="password" name="pass"></p>
        <?php
            if( $error["pass"] == "blank" ):
        ?>
            <p>パスワードを入力してください</p>
        <?php
            endif;
        ?>
        <?php
            if( $error["pass"] == "length" ):
        ?>
            <p>パスワードは6文字以上で入力してください</p>
        <?php
            endif;
        ?>
        <input type="submit" name="sub" value="登録">
    </form>
</body>
</html>