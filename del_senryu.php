<?php
session_start();
include("funcs.php");
sschk();

$pdo = db_conn();
$user_id = $_SESSION['user_id']; // 現在のユーザーID
$senryu_id = $_POST['id']; // 削除する投稿のID

// 投稿を削除するSQL
$sql = "DELETE FROM P_senryu_table WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $senryu_id, PDO::PARAM_INT);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false) {
    echo "エラー";
} else {
    echo "削除しました";
}
?>
