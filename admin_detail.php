<?php 
    // セッションスタート
    session_start();
    
    // データがない場合は、エラー表示
    if(isset($_SESSION['login_pass']) != TRUE){
        //空の配列を代入し、すべてのセッション変数を消去 
        $_SESSION = array();
        $_GET = array();
        //セッションを破棄
        session_destroy(); 
        die('Access denied');
        exit();
    }

    // GETされたIDがない場合は、エラー表示
    if(empty($_GET["id"])){
        //空の配列を代入し、すべてのセッション変数を消去
        $_SESSION = array(); 
        $_GET = array();
        //セッションを破棄
        session_destroy(); 
        die('Access denied');
        exit();
    }
   
    // admin_list.htmlからGETされた変数を格納
    $id = htmlspecialchars($_GET["id"]);
    
    // お問い合わせ詳細表示
    // MySQLに接続
    $user = 'root';
    $password = 'root';

    try{
        // DB接続成功
        $db = new PDO('mysql:dbname=contact;host=localhost;
        charset=utf8', $user, $password);
        $stmt = $db->prepare("SELECT * FROM `contact` WHERE id = :id");
        $stmt->bindValue(":id" , $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // データ格納
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // データがない場合
        if(empty($row)){
            die('データ格納エラー');
            exit();
        }

    }catch(PDOException $e){
        // echo 'DB接続エラー！: ' . $e->getMessage();
        exit();
    }
    include ('admin_detail.html');
?>
