<?php
// 開発中エラー確認
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("funcs.php");
$pdo = db_conn(); // DB接続関数の呼び出し

if(isset($_POST["theme"])) { // フォームが送信されたかをチェック
    $user_id = $_POST['user_id']; // 
    $user_name = $_POST['user_name']; // 

    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';

    $theme = $_POST['theme']; // テーマ
    $s_text1 = $_POST['s_text1']; // 上５（データの長さチェックはない）
    $s_text2 = $_POST['s_text2']; // 中７
    $s_text3 = $_POST['s_text3']; // 下５
    $img_path = urlencode('senryudata/dfo.jpg'); // デフォルト値

    $img_path = 'senryudata/dfo.jpg';  // デフォルト値

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'senryudata/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
    
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $img_path = $uploadFile; // 成功時にパスを更新
        } else {
            echo "ファイルのアップロードに失敗しました。";
        }
    }
    
    var_dump($_FILES);
    // データベース保存処理...
    
    
    // データ登録SQL作成
    $stmt = $pdo->prepare("INSERT INTO P_senryu_table(user_id, user_name,theme, s_text1, s_text2, s_text3, img_path, iine, created_at) VALUES (:user_id, :user_name, :theme, :s_text1, :s_text2, :s_text3, :img_path, 0, sysdate())");
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
    $stmt->bindValue(':theme', $theme, PDO::PARAM_STR);
    $stmt->bindValue(':s_text1', $s_text1, PDO::PARAM_STR);
    $stmt->bindValue(':s_text2', $s_text2, PDO::PARAM_STR);
    $stmt->bindValue(':s_text3', $s_text3, PDO::PARAM_STR);

    $stmt->bindValue(':img_path', $img_path, PDO::PARAM_STR);

    $status = $stmt->execute(); // SQL文を実行

  // データ登録処理後
  if($status == false) {
    sql_error($stmt); // SQLエラーの場合の処理
} else {
    redirect("index.php"); // 処理成功後にリダイレクト
}
} else {
    echo ("エラー");
// POSTデータが存在しない場合のエラー処理や処理
}

exit();
?>