<?php
    require_once("./database.php");
    require_once("./functions.php");

    $result = false;

    $stmt = $dbh->prepare("SELECT * from categories WHERE category_id = ?;");
    $stmt->bindParam(1, $_GET['category_id'], PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST)) {
        foreach($_POST['task'] as $task_name) {
          $stmt = $dbh->prepare("INSERT INTO tasks(category_id, task_name) VALUES (?, ?)");
          $stmt->bindParam(1, $_GET['category_id'], PDO::PARAM_INT);
          $stmt->bindParam(2, $task_name, PDO::PARAM_STR);
          $stmt->execute();
        }
        $result = true;
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク登録</title>
</head>
<body>
    <h1>タスク登録</h1>

    <?php if($result): ?>
      <p>データベースに登録しました。</p>
      <p><a href="./project.php?project_id=<?php echo h($category['project_id']) ?>">プロジェクトページ</a></p>
    <?php else: ?>

    <div>
      <button type="button" class="btn btn-info" onclick="clickBtn1()">タスク行を追加する</button>
    </div>

    <form action="./create-task.php?category_id=<?php echo h($category['category_id']) ?>" method="post">
    <div id="container">
      <div class="template">
        <div class="form-inline">
          <div class="form-group">
            <div class="col-sm-6">
              <input type="text" class="form-control" name="task[]">
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