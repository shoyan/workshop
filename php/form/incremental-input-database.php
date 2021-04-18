<?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);
/**
 * データベースの接続
 */
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'workshop');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '3306');

// 文字化け対策
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'");

// データベースの接続
try {
  $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, $options);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}

$result = false;
$taskList = [];
if (!empty($_POST)) {
  foreach($_POST['task'] as $index => $task) {
    if (!empty($_POST['task'][$index])) {
      $stmt = $dbh->prepare("INSERT INTO tasks(task_name, deadline) VALUES (:task_name, :deadline)");
      $stmt->bindParam(':task_name', $_POST['task'][$index], PDO::PARAM_STR);
      $stmt->bindParam(':deadline', $_POST['deadline'][$index], PDO::PARAM_STR);
      $stmt->execute();
      $result = true;
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
  <?php if($result): ?>
    <p>データベースに登録しました。</p>
  <?php endif ?>
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
