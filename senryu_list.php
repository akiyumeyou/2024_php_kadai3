<?php
//0. SESSION開始！！
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

//１．関数群の読み込み
include("funcs.php");

//LOGINチェック → funcs.phpへ関数化しましょう！
sschk();

//２．データ登録SQL作成
$pdo = db_conn();
$sql = "SELECT * FROM P_senryu_table ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$senryus = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>川柳</title>
<link href="css/senryu.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP&display=swap" rel="stylesheet">

</head>
<body>

 <?php include("inc/head.html"); ?>


<div class="senryu-container">
    <?php
    foreach ($senryus as $senryu) {
        echo '<div class="senryu">';
        echo '<div class="senryu-text">';
        echo '<p>' . htmlspecialchars($senryu['s_text1']) . '</p>';
        echo '<p>' . htmlspecialchars($senryu['s_text2']) . '</p>';
        echo '<p>' . htmlspecialchars($senryu['s_text3']) . '</p>';
        echo '</div>';
        // echo '<img src="' . htmlspecialchars($senryu['img_path']) . '" alt="川柳画像" class="senryu-image">';
        $file_path = htmlspecialchars($senryu['img_path']);
        $file_ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        if ($file_ext == 'mp4') {
            // 動画の場合
            echo '<video controls class="senryu-video">';
            echo '<source src="' . $file_path . '" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
        } else {
            // 画像の場合
            echo '<img src="' . $file_path . '" alt="川柳画像" class="senryu-image">';
      
        }
        echo '<button class="iine-btn" data-id="' . htmlspecialchars($senryu['id']) . '">❤️ ' . htmlspecialchars($senryu['iine']) . '</button>';
        echo '<div class="author">投稿者: ' . htmlspecialchars($senryu['user_name']) . '</div>';
        // ユーザー自身が登録した投稿の場合のみ「削除」ボタンを表示
        if ($_SESSION['user_id'] == $senryu['user_id']) {
            echo '<button class="delete-btn" data-id="' . htmlspecialchars($senryu['id']) . '">削除</button>';
        }

        echo '<div class="hr"></div>';
        echo '</div>';
    }
    ?>
</div>

<footer class="footer">
<?php include("inc/foot.html"); ?>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 「いいね」ボタンに対するイベントリスナーの追加
    document.querySelectorAll('.iine-btn').forEach(button => {
        button.addEventListener('click', function () {
            const senryuId = this.getAttribute('data-id');
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_iine.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = () => {
                if (xhr.status === 200) {
                    // レスポンスとして新しい「いいね」の数を受け取り、表示を更新
                    this.innerHTML = '❤️ ' + xhr.responseText;
                }
            };
            xhr.send('id=' + encodeURIComponent(senryuId));
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const senryuId = this.getAttribute('data-id');
            if (confirm('本当に削除しますか？')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'del_senryu.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = () => {
                    if (xhr.status === 200) {
                        // 成功したら、その投稿をページから削除
                        this.parentElement.remove();
                    } else {
                        // エラー処理...
                        alert('削除に失敗しました。');
                    }
                };
                xhr.send('id=' + encodeURIComponent(senryuId));
            }
        });
    });
});


    function toggleMenu() {
        var navbarHeader = document.getElementById("navbar-header");
        if (navbarHeader.style.display === "flex") {
            navbarHeader.style.display = "none";
        } else {
            navbarHeader.style.display = "flex";
        }
    }


</script>
</body>
</html>
