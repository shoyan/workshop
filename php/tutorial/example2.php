<?php
    // PHPのエラーを表示するように設定
    ini_set('display_errors', "1");
    // E_NOTICE を表示させるのもおすすめ（初期化されていない変数、変数名のスペルミスなど…）
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

    // 変数が存在するかをチェック
    if (isset($_GET['user_name'])) {
        $userName = $_GET['user_name'];
    }
    // 条件分岐
    if (empty($userName)) {
        $message = "名前を教えてください！";
    } else {
        $message = "こんにちは！" . $userName . "さん";
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello World</title>
</head>
<body>
    <form action="example2.php">
        <input type="text" name="user_name">
        <button type="submit">送信</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>