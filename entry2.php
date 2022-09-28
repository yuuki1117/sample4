<?php
require("./dbconect.php");//dbconect.phpを読み込みDBと接続//
session_start();//セッション使用のため明示//
 
if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if ($_POST['email'] === "") {
        $error['email'] = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }
    if ($_POST['name'] === "") {
        $error['name'] = "blank";
    }
    if ($_POST['adress'] === "") {
        $error['adress'] = "blank";
    }
    if ($_POST['textarea_text'] === "") {
        $error['textarea_text'] = "blank";
    }
    if ($_POST['name_furi'] === "") {
        $error['name_furi'] = "blank";
    }
    // if ($_POST['gender'] === "") {
    //     $error['gender'] = "blank";
    // }
    
    /* メールアドレスの重複を検知 */
    if (!isset($error)) {
        $member = $db->prepare('SELECT COUNT(*) as cnt FROM user WHERE email=?');
        $member->execute(array(
            $_POST['email']
        ));
        $record = $member->fetch();
        if ($record['cnt'] > 0) {
            $error['email'] = 'duplicate';
        }
    }
 
    /* エラーがなければ次のページへ */
    if (!isset($error)) {
        $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
        header('Location: check2.php');   // check.phpへ移動
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>申し込みフォーム</title>
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content">
        <form action="" method="POST">
            <h1>申し込みフォーム</h1>
            <p>下記フォームに必要事項をご記入ください。</p>
            <br>
 
            <div class="control">
                <label for="name">氏名<span class="required">必須</span></label>
                <input id="name" type="text" name="name"></input>
                <?php if (!empty($error["name"]) && $error['name'] === 'blank'): ?>
                    <p class="error">＊氏名を入力してください</p>
                <?php endif ?>
            </div>

            <div class="control">
                <label for="name_furi">ふりがな<span class="required">必須</span></label>
                <input id="name_furi" type="text" name="name_furi"></input>
                <?php if (!empty($error["name_furi"]) && $error['name_furi'] === 'blank'): ?>
                    <p class="error">＊ふりがなを入力してください</p>
                <?php endif ?>
            </div>

            <!-- <div class="control">
                <label for="gender">性別<span class="required">必須</span></label>
                <input id="gender" type="radio" name="gender" >男性</input>
                <input id="gender" type="radio" name="gender" >女性</input>
                <?php if (!empty($error["gender"]) && $error['gender'] === 'blank'): ?>
                    <p class="error">＊選択してください</p>
                <?php endif ?>
            </div> -->

            <div class="control">
                <label for="adress">住所<span class="required">必須</span></label>
                <input id="adress" type="text" name="adress"></input>
                <?php if (!empty($error["adress"]) && $error['adress'] === 'blank'): ?>
                    <p class="error">＊住所を入力してください</p>
                <?php endif ?>
            </div>
 
            <div class="control">
                <label for="email">メールアドレス<span class="required">必須</span></label>
                <input id="email" type="email" name="email"></input>
                <?php if (!empty($error["email"]) && $error['email'] === 'blank'): ?>
                    <p class="error">＊メールアドレスを入力してください</p>
                <?php elseif (!empty($error["email"]) && $error['email'] === 'duplicate'): ?>
                    <p class="error">＊このメールアドレスはすでに登録済みです</p>
                <?php endif ?>
            </div>
 
            <div class="control">
                <label for="password">パスワード<span class="required">必須</span></label>
                <input id="password" type="password" name="password"></input>
                <?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
                    <p class="error">＊パスワードを入力してください</p>
                <?php endif ?>
            </div>

            <div class="control">
                <label for="textarea_text">お問い合わせ内容<span class="required">必須</span></label>
                <textarea name="textarea_text" rows="10" id="textarea_text" type="text" style= "width:100%";></textarea>
                <?php if (!empty($error["textarea_text"]) && $error['textarea_text'] === 'blank'): ?>
                    <p class="error">＊お問い合わせ内容を入力してください</p>
                <?php endif ?>
            </div>
 
            <div class="control">
                <button type="submit" class="btn">送信する</button>
            </div>
        </form>
    </div>
</body>
</html>