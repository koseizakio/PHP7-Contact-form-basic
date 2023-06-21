<?php 
    session_start();
    // データがない場合は、エラー表示
    if(empty($_SESSION)){

        //空の配列を代入し、すべてのセッション変数を消去 
        $_SESSION = array(); 
        //セッションを破棄
        session_destroy(); 
        die('Access denied');
        exit();
    }
    //送信成功した場合はセッションを破棄
    //空の配列を代入し、すべてのセッション変数を消去 
    $_SESSION = array(); 
    //セッションを破棄
    session_destroy(); 
    
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>コンタクトフォーム（完了）</title>
        <link href="style.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container">
            <h2>お問い合わせフォーム</h2>
            <h3>送信完了!</h3>
            <p>お問い合わせいただきありがとうございます。</p>
            <p>送信完了いたしました。</p>
        </div>
    </body>
</html>