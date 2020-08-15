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
  <form action="./checkbox2.php" method="post">
    <div>
      <input type="checkbox" name="id[]" value="1" id="id1">
      <label for="id1">id:1</label>
    </div>
    <div>
      <input type="checkbox" name="id[]" value="2" id="id2">
      <label for="id2">id:2</label>
    </div>
    <div>
      <input type="checkbox" name="id[]" value="3" id="id3">
      <label for="id3">id:3</label>
    </div>
    <button type="submit">削除</button>
  </form>
</body>
</html>
