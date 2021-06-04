<?php
$error = '';
$result = 0;
if (empty($_GET['one'])){
  $error = '数字を入力してください。';
} else {
    if ($_GET['operand'] === '+') {
        $result = $_GET['one'] + $_GET['two'];
    } elseif ($_GET['operand'] === '-') {
        $result = $_GET['one'] - $_GET['two'];
    } elseif ($_GET['operand'] === '×') {
        $result = $_GET['one'] * $_GET['two'];
    } elseif ($_GET['operand'] === '/') {
        $result = $_GET['one'] / $_GET['two'];
    } else {
        $error = '不明な演算子です。';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>簡易計算機</h1>
    <form action="calc2.php">
        <input type="text" name="one">
        <select name="operand">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="×">×</option>
            <option value="/">/</option>
        </select>
        <input type="text" name="two">
        <button type="submit">送信</button>

        <?php if (!empty($error)): ?>
            <p>数字を入力してください。</p>
        <?php else: ?>
            <p><?php echo $_GET['one'] ?> <?php echo $_GET['operand'] ?> <?php echo $_GET['two'] ?> = <?php echo $result; ?></p>
        <?php endif ?>
    </form>
</body>
</html>