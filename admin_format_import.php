<?php
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

    // メッセージ初期化
    $msg = NULL;

    try {
        // ファイルアップロードエラーチェック 
        switch ($_FILES['upfile']['error']) {
            case UPLOAD_ERR_OK:
                // エラー無し
                break;
            case UPLOAD_ERR_NO_FILE:
                // ファイル未選択
                throw new RuntimeException('ファイルがありません');
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                // 許可サイズを超過
                throw new RuntimeException('ファイル容量は、32MB以内でお願いします');
                break;
            default:
                // 想定外のエラー
                throw new RuntimeException('想定外のエラーです');
                break;
        }
        
        // ファイルチェック
        $tmp_name = $_FILES['upfile']['tmp_name'];
        $file_name = $_FILES['upfile']['name'];
        $file_size = $_FILES['upfile']['size'];
        $detect_order = 'ASCII,JIS,UTF-8,CP51932,SJIS-win';
        setlocale(LC_ALL, 'ja_JP.UTF-8');
    
        // 拡張子を判定
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            throw new RuntimeException('CSVファイルをアップロードしてください');
        }
    
        // ファイルの中身チェック
        if($file_size == 0){
            throw new RuntimeException('CSVファイルに書き込みしてください');
        }
        
        // 文字コードを変換してファイルを置換 
        $buffer = file_get_contents($tmp_name);
        if (!$encoding = mb_detect_encoding($buffer, $detect_order, true)) {
            // 文字コードの自動判定に失敗
            unset($buffer);
            throw new RuntimeException('文字コードは、UTF-8でお願いします');
        }
        file_put_contents($tmp_name, mb_convert_encoding($buffer, 'UTF-8', $encoding));
        unset($buffer);

        // MySQLに接続
        $user = 'root';
        $password = 'root';
        $pdo = new PDO('mysql:dbname=contact;host=localhost;charset=utf8',$user,$password);
        $stmt = $pdo->prepare('INSERT INTO contact (name, name_furi, age, email, subject, body, date) VALUES (:name, :name_furi, :age, :email, :subject, :body, :date);');

        // トランザクション処理
        $pdo->beginTransaction();
        try {

            // ファイル読み込み
            $fp = fopen($tmp_name, 'r');
            // 1行目のカラムスキップ
            unset(fgetcsv($fp)[0]);

            while ($row = fgetcsv($fp)) {

                if ($row === array(null)) {
                    // 空行はスキップ
                    continue;
                }

                if (count($row) !== 6) {
                    // カラム数が異なる無効なフォーマット
                    throw new RuntimeException('カラム数は、6つです');
                }

                $stmt->bindValue(':name', $row[0], PDO::PARAM_STR);
                $stmt->bindValue(':name_furi', $row[1], PDO::PARAM_STR);
                $stmt->bindValue(':age', $row[2], PDO::PARAM_INT);
                $stmt->bindValue(':email', $row[3], PDO::PARAM_STR);
                $stmt->bindValue(':subject', $row[4], PDO::PARAM_STR);
                $stmt->bindValue(':body', $row[5], PDO::PARAM_STR);
                $stmt->bindValue(':date', date("Y-m-d H:i:s"), PDO::PARAM_STR);
                $stmt->execute();

            }

            if (!feof($fp)) {
                // ファイルポインタが終端に達していなければエラー
                throw new RuntimeException('ファイルポインタが終端に達していません');
            }

            // データ挿入成功
            $msg = "データが挿入されました";

            fclose($fp);
            $pdo->commit();
            
        } catch (Exception $e) {
            fclose($fp);
            $pdo->rollBack();
            throw $e;
        }
    
    } catch (Exception $e) {    
        // エラーメッセージをセット
        $msg = $e->getMessage();
    }

    // URLエンコード
    $msg = urlencode($msg);

    // admin_list.php読込
    header("Location: admin_list.php?msg=".$msg);
    exit();
?>
