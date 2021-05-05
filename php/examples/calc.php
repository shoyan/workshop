<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="calc.php">
        <p>数字を入力してください。足算をした結果を表示します</p>
        <input type="text" name="one">
        <input type="text" name="two">
        <button type="submit">送信</button>
        <?php if (empty($_GET['one'])): ?>
            <p>数字を入力してください。</p>
        <?php else: ?>
            <p>合計は「<?php echo $_GET['one'] + $_GET['two']?>」です。</p>
        <?php endif ?>
    </form>
</body>
</html>