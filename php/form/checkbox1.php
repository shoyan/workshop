<?php
if (!empty($_POST)) {
  print_r($_POST);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="./checkbox.php" method="post">
    <input type="hidden" name="id" value="1">
    <div>
      id:1
      <button type="submit">削除</button>
    </div>
  </form>
  <form action="./checkbox.php" method="post">
    <input type="hidden" name="id" value="2">
    <div>
      id:2
      <button type="submit">削除</button>
    </div>
  </form>
  <form action="./checkbox.php" method="post">
    <input type="hidden" name="id" value="3">
    <div>
      id:3
      <button type="submit">削除</button>
    </div>
  </form>
</body>
</html>
