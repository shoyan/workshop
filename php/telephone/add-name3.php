<?php
// 入力されたデータを変数に設定する
// 入力されていない場合（初期表示時など）は空文字を設定する
if (isset($_GET["username"])) {
    $username = $_GET["username"];
} else {
    $username = '';
}

if (isset($_GET["tel"])) {
    $tel = $_GET["tel"];
} else {
    $tel = '';
}

$error_message = '';

// 名前が入力されていることをチェックする
if (isset($_GET["username"]) && $_GET['username'] == '') {
    $error_message = '名前を入力してください。';
}

// 電話番号が入力されていることをチェックする
if (isset($_GET["tel"]) && $_GET['tel'] == '') {
    $error_message = '電話番号を入力してください。';
} else if (!preg_match('/^[0-9-]+$/', $_GET['tel'])) {
    $error_message = '電話番号は数字以外は入力できません。';
} 

// 電話番号をファイル(tel.txt)に書き込む
if ($error_message == '' && !empty($_GET["username"]) && !empty($_GET["tel"])) {
    $f = fopen("tel.txt", "a");
    fwrite($f, "名前:" . $_GET["username"] . " 電話番号:". $_GET["tel"] . "\n");
    fclose($f);
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

    <form action="./add-name3.php" method="get">
        <input type="text" name="username" placeholder="名前" value="<?php echo $username ?>">
        <input type="text" name="tel" placeholder="電話番号" value="<?php echo $tel?>">
        <p class="error"><?php echo $error_message ?></p>
        <input type="submit" value="登録">
    </form>
    <h2>登録された電話番号一覧</h2>

    <pre><?php echo file_get_contents("tel.txt"); ?></pre>
</body>

</html>