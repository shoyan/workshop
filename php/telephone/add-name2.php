<?php
print_r($_GET);

$error_message = [];

// 名前が入力されていることをチェックする
if (isset($_GET["username"]) && $_GET['username'] == '') {
    $error_message[] = '名前を入力してください。';
}

// 電話番号が入力されていることをチェックする
if (isset($_GET["tel"]) && $_GET['tel'] == '') {
    $error_message[] = '電話番号を入力してください。';
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

    <form action="./add-name2.php" method="get">
        <input type="text" name="username" placeholder="名前">
        <input type="text" name="tel" placeholder="電話番号">
        <ul class="error">
            <?php foreach($error_message as $message): ?>
                <li><?php echo $message ?></li>
            <?php endforeach ?>
        </ul>
        <input type="submit" value="登録">
    </form>
    <h2>登録された電話番号一覧</h2>

    <pre><?php echo file_get_contents("tel.txt"); ?></pre>
</body>

</html>