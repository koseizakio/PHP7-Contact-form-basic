<?php 
    // セッションスタート
    session_start();

    // データがない場合は、エラー表示
    if(isset($_SESSION['login_pass']) != TRUE){
        //空の配列を代入し、すべてのセッション変数を消去 
        $_SESSION = array();
        //セッションを破棄
        session_destroy(); 
        die('Access denied');
        exit();
    }

    // お問い合わせ一覧表示
    // MySQLに接続
    $user = 'root';
    $password = 'root';

    try{
        // DB接続成功
        $db = new PDO('mysql:dbname=contact;host=localhost;
        charset=utf8', $user, $password);
        $stmt = $db->prepare("SELECT * FROM `contact`");
        $stmt->execute();

        // データ格納
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // データ格納チェック
        if(empty($rows)){
            die('データ格納エラー');
            exit();
        }

        $id = 1;
        foreach($rows as $row){ 
            // 個数チェック
            $id_check[$id] = $row["id"];
            // お問い合わせ情報                    
            $name[$id] = $row["name"];
            $name_furi[$id] = $row["name_furi"];
            $age[$id] = $row["age"];
            $email[$id] = $row["email"];
            $subject[$id] = $row["subject"];                
            $date[$id] = $row["date"];
            $id++;
        }

    }catch(PDOException $e){
        echo 'DB接続エラ-' . $e->getMessage();
        exit();
    }
    // HTML読込
    include ('admin_list.html');
?>