<?php
require("./dbconect.php");
session_start();
 
/* 会員登録の手続き以外のアクセスを飛ばす */
if (!isset($_SESSION['join'])) {
    header('Location: entry2.php');
    exit();
}
 
if (!empty($_POST['check'])) {
    // パスワードを暗号化
    // $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);
 
    // 入力情報をデータベースに登録
    $statement = $db->prepare("INSERT INTO user SET name=?, email=?, password=?, name_furi=?, adress=?,textarea_text=?");
    $statement->execute(array(
        $_SESSION['join']['name'],
        $_SESSION['join']['email'],
        $_SESSION['join']['password'],
        $_SESSION['join']['name_furi'],
        $_SESSION['join']['adress'],
        $_SESSION['join']['textarea_text'],
        // $hash
    ));
 
    unset($_SESSION['join']);   // セッションを破棄
    header('Location: thank2.php');   // thank.phpへ移動
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>確認画面</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="content">
        <form action="" method="POST">
            <input type="hidden" name="check" value="checked">
            <h1>入力情報の確認</h1>
            <p>ご入力情報に変更が必要な場合、下記変更ボタンで変更を行ってください。</p>
            <p>※入力された情報につきましては送信後に変更することはできませんのでご注意くださいませ。</p>
            <?php if (!empty($error) && $error === "error"): ?>
                <p class="error">＊会員登録に失敗しました。</p>
            <?php endif ?>
            <hr>
 
            <div class="control">
                <p>氏名</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info">
                    <?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="control">
                <p>ふりがな</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info">
                    <?php echo htmlspecialchars($_SESSION['join']['name_furi'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="control">
                <p>住所</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info">
                    <?php echo htmlspecialchars($_SESSION['join']['adress'], ENT_QUOTES); ?></span></p>
            </div>
 
            <div class="control">
                <p>メールアドレス</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info">
                    <?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="control">
                <p>パスワード</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info">
                    <?php echo htmlspecialchars($_SESSION['join']['password'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="control">
                <p>お問い合わせ内容</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info">
                    <?php echo htmlspecialchars($_SESSION['join']['textarea_text'], ENT_QUOTES); ?></span></p>
            </div>
            
            <br>
            <a href="entry2.php" class="back-btn">変更する</a>
            <button type="submit" class="btn next-btn">登録する</button>
            <div class="clear"></div>
        </form>
    </div>
</body>
</html>