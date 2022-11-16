<?php
// 電話番号をファイル(tel.txt)に書き込む
if (isset($_GET["tel"])) {
    $f = fopen("tel.txt", "a");
    fwrite($f, $_GET["tel"] . "\n");
    fclose($f);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>電話帳</title>
</head>

<body>
    <h1>電話帳</h1>
    <form action="./index.php" method="get">
        <input type="text" name="tel" placeholder="電話番号">
        <input type="submit" value="登録">
    </form>
    <h2>登録された電話番号一覧</h2>

    <pre><?php echo file_get_contents("tel.txt"); ?></pre>
</body>

</html>