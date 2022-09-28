<?php
require("./dbconect.php");//dbconect.phpを読み込みDBと接続//
session_start();//セッション使用のため明示//


if (!empty($_POST)) {
    if ($_POST['email'] === "") {
        $error['email'] = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }

    //氏名確認
    if (!isset($error)) {
        $user = $db->prepare('SELECT COUNT(*) as cnt FROM user WHERE name=?');
        $user->execute(array(
            $_POST['name']
        ));
        $record = $user->fetch();
        if ($record['cnt'] == 1) {
        }else{
            $error['name'] = 'era';
        }
    }

//メールアドレス確認
    if (!isset($error)) {
        $user = $db->prepare('SELECT COUNT(*) as cnt FROM user WHERE email=?');
        $user->execute(array(
            $_POST['email']
        ));
        $record = $user->fetch();
        if ($record['cnt'] == 1) {
        }else{
            $error['email'] = 'era';
        }
    }

    //パスワード確認
    if (!isset($error)) {
        $user = $db->prepare('SELECT COUNT(*) as cnt FROM user WHERE password=?');
        $user->execute(array(
            $_POST['password']
        ));
        $record = $user->fetch();
        if ($record['cnt'] == 1) {
        }else{
            $error['password'] = 'era';
        }
    }

    if (!isset($error)) {
        $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
        header('Location: kaiin.php');   // kaiin.phpへ移動
        exit();
    }
  

}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>ログイン画面</title>
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="content">
        <form action="" method="POST">
            <h1>ログイン画面</h1>
            <p>当サービスをご利用するために、次のフォームに必要事項を入力ください。</p>
            <br>
 
            <div class="control">
                <label for="name">氏名<span class="required">必須</span></label>
                <input id="name" type="text" name="name">
                <?php if (!empty($error["name"]) && $error['name'] === 'blank'): ?>
                    <p class="error">＊氏名を入力してください</p>
                    <?php elseif (!empty($error["name"]) && $error['name'] === 'era'): ?>
                    <p class="error">＊この氏名は登録されておりません</p>
                <?php endif ?>
            </div>
 
            <div class="control">
                <label for="email">メールアドレス<span class="required">必須</span></label>
                <input id="email" type="email" name="email">
                <?php if (!empty($error["email"]) && $error['email'] === 'blank'): ?>
                    <p class="error">＊メールアドレスを入力してください</p>
                    <?php elseif (!empty($error["email"]) && $error['email'] === 'era'): ?>
                    <p class="error">＊このメールアドレスは登録されておりません</p>
                <?php endif ?>
            </div>
 
            <div class="control">
                <label for="password">パスワード<span class="required">必須</span></label>
                <input id="password" type="password" name="password">
                <?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
                    <p class="error">＊パスワードを入力してください</p>
                <?php endif ?>
                <?php if (!empty($error["password"]) && $error['password'] === 'era'): ?>
                    <p class="error">＊パスワードが誤っています。</p>
                <?php endif ?>
            </div>
 
            <div class="control">
                <button type="submit" class="btn">ログインする</button>
            </div>
        </form>
    </div>
</body>
</html>