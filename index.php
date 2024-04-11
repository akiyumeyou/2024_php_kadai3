<?php
//0. SESSION開始！！
session_start();

//１．関数群の読み込み
include("funcs.php");

//LOGINチェック → funcs.phpへ関数化しましょう！

// sschk();


?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>THE川柳</title>
        <link href="css/senryu.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP&display=swap" rel="stylesheet">

    </head>


<body>
<header class="header">
<?php include("inc/menu.php");?>
<?php 
    // ログインしている場合、ユーザー名を表示
    if(isset($_SESSION["user_name"])) {
        echo $_SESSION["user_name"] . "さん";
    }
?>
</header>

<div class="senryu-container">
    <div class="senryu-text vertical-text">
        <p>ようこそ シニア川柳へ</p>
    </div>
    <div class="senryu-image">
        <a href="senryu_new.php" class="image-link toukou">
            <span class="image-text">👉川柳投稿</span>
            <img src="img/toukou.png" alt="川柳投稿">
        </a>
        <a href="senryu_list.php" class="image-link haiken">
            <span class="image-text">👉川柳拝見</span>
            <img src="img/haiken.png" alt="川柳拝見">
        </a>
    </div>
</div>


 <footer class="footer">
<?php include("inc/foot.html"); ?>
</footer>

</body>
</html>
