<?php
//0. SESSION開始！！
session_start();

//１．関数群の読み込み
include("funcs.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

//LOGINチェック → funcs.phpへ関数化しましょう！
sschk();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>川柳投稿フォーム</title>
    <link href="css/senryu.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP&display=swap" rel="stylesheet">

</head>
<body>


    <?php include("inc/head.html"); ?>


<!-- Main[Start] -->
<div class="senryu">
<form method="POST" action="senryu_write.php" enctype="multipart/form-data"><!-- enctype="" -->

<div class="button">
    <fieldset class="senryu-text">
        <legend>川柳投稿</legend>
        <label>投稿者：<?= htmlspecialchars($_SESSION["user_name"], ENT_QUOTES); ?></label><br>
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION["user_id"], ENT_QUOTES); ?>">
        <input type="hidden" name="user_name" value="<?= htmlspecialchars($_SESSION["user_name"], ENT_QUOTES); ?>">
    
        <input type="text" id="title" name="theme" placeholder="川柳テーマ" class="senryu-input"><br><br>
    <input type="text" name="s_text1" placeholder="上五" class="senryu-input"><br>
    <input type="text" name="s_text2" placeholder="中七" class="senryu-input"><br>
    <input type="text" name="s_text3" placeholder="下五" class="senryu-input"><br>
    <label for="image"></label><br>
    </fieldset>
    <div id="drop-area" class="senryu-text">
        <p>画像をドロップまたは<span class="file-input-label">タップ</span>して選択</p>
        <input type="file" id="image" name="image" hidden accept="image/*"><br><br>
        <div id="file-name"></div>
    </div><br>
    <input type="submit" value="川柳を投稿" class="toukou_btn">
                    

</div>
</form>
</div>
<!-- Main[End] -->

<footer class="footer">
<?php include("inc/foot.html"); ?>
</footer>



<<script>
document.addEventListener("DOMContentLoaded", function() {
    let dropArea = document.getElementById('drop-area');
    let input = document.getElementById('image');

    // クリックでファイル選択
    dropArea.addEventListener('click', function() {
        input.click();
    });

    // ファイルが選択された時にファイル名を表示
    input.addEventListener('change', function(e) {
        let fileNameContainer = document.getElementById('file-name');
        if (input.files.length > 0) {
            let fileName = input.files[0].name;
            fileNameContainer.textContent = "選択されたファイル: " + fileName;
        } else {
            fileNameContainer.textContent = "";
        }
    });

    // ドラッグオーバー時のスタイル変更
    dropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropArea.classList.add('active');
    });

    // ドラッグがエリア外に出た時のスタイル戻し
    dropArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropArea.classList.remove('active');
    });

    // ドロップされたファイルをinputにセットし、ファイル名を表示
    dropArea.addEventListener('drop', function(e) {
        e.preventDefault();
        dropArea.classList.remove('active');
        input.files = e.dataTransfer.files;

        // ファイル名を表示
        let fileNameContainer = document.getElementById('file-name');
        if (input.files.length > 0) {
            let fileName = input.files[0].name;
            fileNameContainer.textContent = "選択されたファイル: " + fileName;
        } else {
            fileNameContainer.textContent = "";
        }
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

 