<?php
$taskList = [];
if (!empty($_POST)) {
  foreach($_POST['task'] as $index => $task) {
    if (!empty($_POST['task'][$index])) {
      $taskList[$index]['task'] = $_POST['task'][$index];
      $taskList[$index]['deadline'] = empty($_POST['deadline'][$index])? null : $_POST['deadline'][$index];
    }
  }
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    .template {
      margin: 10px 0;
      border: 1px solid #ddd;
      max-width: 200px;
      padding: 10px;
    }
  </style>
</head>

<body>
  <div>
    <button type="button" class="btn btn-info" onclick="clickBtn1()">タスク行を追加する</button>
  </div>

  <form action="" method="post">
    <div id="container">
      <div class="template">
        <div class="form-inline">
          <div class="form-group">
            <div class="col-sm-6">
              <input type="text" class="form-control" name="task[]">
            </div>
            <div class="col-sm-4">
              <input type="date" class="form-control" name="deadline[]">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-1">
              <a href="/contact.html" class="btn"><i class="fab fa-twitter-square fa-2x"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <button type="submit">送信</button>
  </form>
  <?php if(!empty($taskList)): ?>
  <ul>
    <?php foreach($taskList as $task): ?>
        <li>タスク名：<?php echo $task['task'] ?></li>
        <li>期日：<?php echo $task['deadline'] ?></li>
    <?php endforeach ?>
  </ul>
  <?php endif ?>

  <script>
    function clickBtn1() {
      // template要素を取得
      const template = document.querySelector('.template');
      // template要素の内容を複製
      const clone = template.cloneNode(true);
      // div#containerの中に追加
      document.getElementById('container').appendChild(clone);
    }
  </script>
</body>

</html>
