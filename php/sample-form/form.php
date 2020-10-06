<?php
var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>サンプルフォーム</title>
</head>

<body>
  <form action="" method="post">
    <div class="form-inline">
      <div class="form-group">
        <input type="checkbox" name="task_id[]" value="1">
        <input type="text" class="form-control" value="タスク1">
        <input type="date" class="form-control" value="2020-10-01">
      </div>
    </div>
    <div class="form-inline">
      <div class="form-group">
        <input type="checkbox" name="task_id[]" value="2">
        <input type="text" class="form-control" value="タスク2">
        <input type="date" class="form-control" value="2020-10-01">
      </div>
    </div>
    <div class="form-inline">
      <div class="form-group">
        <input type="checkbox" name="task_id[]" value="3">
        <input type="text" class="form-control" value="タスク3">
        <input type="date" class="form-control" value="2020-10-01">
      </div>
    </div>
    <button type="submit">送信する</button>
  </form>
</body>

</html>
