<?php
    // セッションスタート
    session_start();

    // パスワードファイル
    require_once ('password.php'); 

    // ログインフォームから
    // POSTされたデータを変数に格納
    // パスワード
    $login_pass = $_POST['login_pass'];
    // エラー初期化
    $error = NULL;
    
    // ログインボタンがクリック場合
    if(isset($_POST['login'])){
        // パスワード
        if($login_pass == NULL){
            // 未記入
            $error = '* パスワードを入力してください';
        }else if($login_pass != $password){
            // パスワードミス
            $error = '* パスワードが不正です';
        }

        // 確認ページへ送信
        if($error == NULL){ 
            // パスワードを暗号化して
            // SESSIONに格納
            $_SESSION['login_pass'] = TRUE;
            header('Location: admin_list.php');
            exit();
        }
    }

    include ('admin_login.html');

?>
