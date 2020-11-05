<?php if ($yourName): ?>
  <p>こんにちは！<?php echo $yourName; ?>さん！</p>
<?php elseif (empty($yourName)): ?>
  <p><?php echo '名前を入力してください！'; ?></p>
<?php endif ?>
<?php
ini_set('display_errors', 1);
echo $_POST['message'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <table border="1">
    <tr>
      <td>$_GET</td>
      <td><?php var_dump($_GET); ?></td>
    </tr>
    <tr>
      <td>$_POST</td>
      <td><?php var_dump($_POST); ?></td>
    </tr>
  </table>
</body>
<a href="./index.html">戻る</a>

</html>
