<?php 
    session_start();

    // メールアドレス等を記述したファイルの読み込み
    require 'mailvars.php'; 
    
    // データがない場合は、エラー表示
    if(empty($_SESSION)){
        //空の配列を代入し、すべてのセッション変数を消去 
        $_SESSION = array(); 
        //セッションを破棄
        session_destroy(); 
        die('Access denied');
        exit();
    }

    // SESSIONされたデータを変数に格納
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : NULL;
    $name_furi = isset($_SESSION['name_furi']) ? $_SESSION['name_furi'] : NULL;
    $age = isset($_SESSION['age']) ? $_SESSION['age'] : NULL;
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : NULL;
    $subject = isset($_SESSION['subject']) ? $_SESSION['subject'] : NULL;
    $body = isset($_SESSION['body']) ? $_SESSION['body'] : NULL;

    // 戻るボタンがクリックされた場合
    if(isset($_POST['return'])){
        header('Location: index.php');
        exit();
    // 送信ボタンがクリックされた場合
    }else if(isset($_POST['send'])){

        // MySQLに接続
        $user = 'root';
        $password = 'root';
        $date = date("Y-m-d H:i:s");

        try{
            $db = new PDO('mysql:dbname=contact;host=localhost;
            charset=utf8', $user, $password);
            echo '<div class="container">
            <h2>お問い合わせフォーム</h2>
            <h3>送信完了!</h3>
            <p>お問い合わせいただきありがとうございます。</p>
            <p>送信完了いたしました。</p>
        </div>', PHP_EOL;
            // データの追加
            $dbd = $db->prepare("INSERT INTO `contact` VALUES(NULL, :name, :name_furi, :age, :email, :subject, :body, :date);");
            $dbd->bindValue(':name', $name, PDO::PARAM_STR);
            $dbd->bindValue(':name_furi', $name_furi, PDO::PARAM_STR);
            $dbd->bindValue(':age', $age, PDO::PARAM_STR);
            $dbd->bindValue(':email', $email, PDO::PARAM_STR);
            $dbd->bindValue(':subject', $subject, PDO::PARAM_STR);
            $dbd->bindValue(':body', $body, PDO::PARAM_STR);
            $dbd->bindValue(':date', $date, PDO::PARAM_STR);
            $dbd->execute();

        }catch (PDOException $e){
            echo 'DB接続エラー！: ' . $e->getMessage();
            exit;
        }

        //メール本文の組み立て
        $mail_body = 'コンタクトページからのお問い合わせ' . "\n\n";
        $mail_body .=  date("Y-m-d H:i:s") . "\n\n"; 
        $mail_body .=  "お名前： " .$name . "\n";
        $mail_body .=  "Email： " . $email . "\n"  ;
        $mail_body .=  "お問い合わせ本文" . "\n" . $body;
        
        //-------- sendmail（mb_send_mail）を使ったメールの送信処理------------
        
        //メールの宛先（名前<メールアドレス> の形式）。値は mailvars.php に記載
        $mailTo = mb_encode_mimeheader(MAIL_TO_NAME) ."<" . $email. ">";
        
        //Return-Pathに指定するメールアドレス
        $returnMail = MAIL_RETURN_PATH; //
        //mbstringの日本語設定
        mb_language( 'ja' );
        mb_internal_encoding( 'UTF-8' );
        
        // 送信者情報（From ヘッダー）の設定
        $header = "From: " . mb_encode_mimeheader($name) ."<" . $email. ">\n";
        $header .= "Cc: " . mb_encode_mimeheader(MAIL_CC_NAME) ."<" . MAIL_CC.">\n";
        $header .= "Bcc: <" . MAIL_BCC.">";
        
        //メールの送信（結果を変数 $result に格納）
        if(ini_get('safe_mode')){
        //セーフモードがOnの場合は第5引数が使えない
            $result = mb_send_mail( $mailTo, $subject, $mail_body, $header );
        }else{
            $result = mb_send_mail( $mailTo, $subject, $mail_body, $header, '-f' . $returnMail );
        }
        
        //メール送信の結果判定
        if($result){
            // 送信成功 complete.phpへ
            header('Location: complete.php');
            exit();
        }else{
            // 送信失敗時（もしあれば）
            echo "メール送信失敗しました";
        }
    }

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>コンタクトフォーム（確認）</title>
        <link href="style.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" >

    </head>

        <body>
        <div class="container">
            <h2>お問い合わせ確認画面</h2>
            <p>以下の内容でよろしければ「送信」をクリックしてください。<br>
            内容を変更する場合は「戻る」をクリックして入力画面にお戻りください。</p>

            <!-- 入力データ表示 -->
            <div class="table-responsive confirm_table">
                <table class="table table-bordered">
                    <h2>ご入力内容</h2>
                    <tr>
                    <th>氏名</th>
                    <td><?php echo $name; ?></td>
                    </tr>

                    <tr>
                    <th>ふりがな</th>
                    <td><?php echo $name_furi; ?></td>
                    </tr>

                    <tr>
                    <th>年齢</th>
                    <td><?php echo $age; ?></td>
                    </tr>

                    <tr>
                    <th>Email</th>
                    <td><?php echo $email; ?></td>
                    </tr>

                    <tr>
                    <th>お問い合わせ名</th>
                    <td><?php echo $subject; ?></td>
                    </tr>

                    <tr>
                    <th>お問い合わせ本文</th>
                    <td><?php echo $body; ?></td>
                    </tr>

                </table>
            </div>

            <form action="confirm.php" method="post">
                <button class="btn btn-primary" type="submit" name="return">戻る</button>
                <button class="btn btn-primary" type="submit" name="send">送信</button>
            </form>
            
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>