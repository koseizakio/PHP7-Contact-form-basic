<?php
    // セッションスタート
    session_start();
    
    // お問い合わせフォームから
    // POSTされたデータを変数に格納
    // 氏名
    $name = isset($_POST['name']) ? $_POST['name'] : NULL;
    // ふりがな
    $name_furi = isset($_POST['name_furi']) ? $_POST['name_furi'] : NULL;
    // 年齢
    $age = isset($_POST['age']) ? $_POST['age'] : NULL;
    // メールアドレス
    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    // 件名
    $subject = isset($_POST['subject']) ? $_POST['subject'] : NULL;
    // お問い合わせ本文
    $body = isset($_POST['body']) ? $_POST['body'] : NULL;

    // お問い合わせフォームから
    // 確認ボタンがクリック場合
    if(isset($_POST['confirmation'])){
        // 名前
        if($name == NULL){
            // 未記入
            $error['name'] = 'blank';
        }else if( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $name ) == 0 ){
            // 30文字超過
            $error['name'] = 'length_over';
        }

        // ふりがな
        if($name_furi == NULL){
            // 未記入
            $error['name_furi'] = 'blank';
        }else if( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $name_furi ) == 0 ){
            // 30文字超過
            $error['name_furi'] = 'length_over';
        }

        // 年齢
        if($age == NULL){
            // 未記入
            $error['age'] = 'blank';
        }else if( preg_match('/^[1-9]?[0-9]{1}$|^[1].[0-2]?[0-9]$|^130/', $age) == 0){
            // 年齢(整数)が0から130の間でない場合
            // 負の数および01など不正入力した場合
            $error['age'] = 'length_over';
        }

        // メール
        if($email == NULL){
            // 未記入
            $error['email'] = 'blank';
        }else{
            // メアド文法チェック
            $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/uiD';
            if ( !preg_match($pattern, $email) ){
                $error['email'] = 'length_over';
            }
        }

        // お問い合わせタイトル
        if($subject == NULL){
            // 未記入
            $error['subject'] = 'blank';
        }else if( preg_match('/\A[\r\n\t[:^cntrl:]]{1,100}\z/u', $subject) == 0 ){
            // 100文字超過
            $error['subject'] = 'length_over';
        }

        // お問い合わせ本文
        if($body == NULL){
            // 未記入
            $error['body'] = 'blank';
        }else if( preg_match('/\A[\r\n\t[:^cntrl:]]{1,1000}\z/u', $body ) == 0 ){
            // 1000文字超過
            $error['body'] = 'length_over';
        }

        // 確認ページへ送信
        if($error == NULL){ 

            // SESSIONされたデータを整形(前後のスペースを削除)
            // SESSIONに格納
            $_SESSION['name'] = trim($name);
            $_SESSION['name_furi'] = trim($name_furi);
            $_SESSION['age'] = trim($age);
            $_SESSION['email'] = trim($email);
            $_SESSION['subject'] = trim($subject);
            $_SESSION['body'] = trim($body);
            header('Location: confirm.php');
            exit();
        }

    // 確認ページから入力ページへの移動
    }else{
        // 確認ページからSESSIONされたデータを変数に格納
        $name = isset($_SESSION['name']) ? $_SESSION['name'] : NULL;
        $name_furi = isset($_SESSION['name_furi']) ? $_SESSION['name_furi'] : NULL;
        $age = isset($_SESSION['age']) ? $_SESSION['age'] : NULL;
        $email = isset($_SESSION['email']) ? $_SESSION['email'] : NULL;
        $subject = isset($_SESSION['subject']) ? $_SESSION['subject'] : NULL;
        $body = isset($_SESSION['body']) ? $_SESSION['body'] : NULL;
    }

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>コンタクトフォーム</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" >

    </head>

    <body>
        <div class="container">

            <h2>お問い合わせフォーム</h2>
            <p>以下のフォームからお問い合わせください。</p>

            <form action="contact.php" method="post">

                <div class="form-group">
                    <lable for="name">氏名(必須)</lable> 
                    <input type="text" id="name" name="name" placeholder="氏名" value="<?php echo $name;?>">

                    <?php if($error['name'] == 'blank'): ?>
                        <p class="error">* 氏名は必須項目です</p>
                    <?php elseif($error['name'] == 'length_over'): ?>
                        <p class="error">* 氏名は30文字以内でお願いします</p>
                    <?php endif; ?>      

                </div>

                <div class="form-group">
                    <lable for="name_furi">ふりがな(必須)</lable> 
                    <input type="text" id="name_furi" name="name_furi" placeholder="ふりがな" value="<?php echo $name_furi;?>">
                    
                    <?php if($error['name_furi'] == 'blank'): ?>
                        <p class="error">* ふりがなは必須項目です</p>
                    <?php elseif($error['name_furi'] == 'length_over'): ?>
                        <p class="error">* ふりがなは30文字以内でお願いします</p>
                    <?php endif; ?>  
                </div>

                <div class="form-group">
                    <lable for="age">年齢(必須)</lable> 
                    <input type="text" id="age" name="age" placeholder="年齢" value="<?php echo $age;?>">
                    
                    <?php if($error['age'] == 'blank'): ?>
                        <p class="error">* 年齢は必須項目です</p>
                    <?php elseif($error['age'] == 'length_over'): ?>
                        <p class="error">* 年齢が不正です</p>
                    <?php endif; ?>  
                </div>

                <div class="form-group">
                    <lable for="email">e-mail(必須)</lable> 
                    <input type="text" id="email" name="email" placeholder="email" value="<?php echo $email;?>">
                    
                    <?php if($error['email'] == 'blank'): ?>
                        <p class="error">* メールアドレスは必須項目です</p>
                    <?php elseif($error['email'] == 'length_over'): ?>
                        <p class="error">* メールアドレスの形式が不正です</p>
                    <?php endif; ?>  
                </div>

                <div class="form-group">
                    <lable for="subject">お問い合わせタイトル(必須)</lable> 
                    <input type="text" id="subject" name="subject" placeholder="件名" value="<?php echo $subject;?>">

                    <?php if($error['subject'] == 'blank'): ?>
                        <p class="error">* 氏名は必須項目です</p>
                    <?php elseif($error['subject'] == 'length_over'): ?>
                        <p class="error">* 氏名は30文字以内でお願いします</p>
                    <?php endif; ?>      

                </div>
                    
                <div class="form-group">
                    <lable for="body">お問い合わせ本文(必須)</lable> 
                    <!-- <span id="count"> </span>/1000      -->
                    <br>
                    <textarea id="body" name="body" cols="50" rows="20" placeholder="お問い合わせ内容（1000文字まで）をお書きください"><?php echo $body;?></textarea>
                    <br>
                        <?php if($error['body'] == 'blank'): ?>
                            <p class="error">* 内容は必須項目です</p>
                        <?php elseif($error['body'] == 'length_over'): ?>
                            <p class="error">* 内容は1000文字以内で入力してください</p>
                        <?php endif; ?>  
                    <br>
                </div>

                <button class="btn btn-primary" type="submit" name="confirmation">確認</button>

            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>

</html>