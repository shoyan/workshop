<?php
// 入力されたデータを変数に設定する
// 入力されていない場合（初期表示時など）は空文字を設定する
if (isset($_GET["tel"])) {
    $tel = $_GET["tel"];
} else {
    $tel = '';
}

// 画面に表示するエラーメッセージ
// エラーがあった場合はこの変数にエラーメッセージを上書きする
$error_message = '';

// 電話番号が入力されていることをチェックする
if (isset($_GET["tel"]) && $_GET['tel'] != '') {
    // 数字かどうかをチェックする
    if (preg_match('/^[0-9-]+$/', $_GET['tel'])) {
        // 電話番号をファイル(tel.txt)に書き込む
        $f = fopen("tel.txt", "a");
        fwrite($f, $_GET["tel"] . "\n");
        fclose($f);
    } else {
        $error_message = '数字以外は入力できません。';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>電話帳</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>電話帳</h1>
    <form action="./index2.php" method="get">
        <input type="text" name="tel" placeholder="電話番号" value="<?php echo $tel ?>">
        <p class="error"><?php echo $error_message ?></p>
        <input type="submit" value="登録">
    </form>
    <h2>登録された電話番号一覧</h2>

    <pre><?php echo file_get_contents("tel.txt"); ?></pre>
</body>

</html>