<?php
    require_once("./database.php");
    require_once("./functions.php");

    $result = false;
    if (!empty($_POST)) {
      $stmt = $dbh->prepare("INSERT INTO projects(project_name, project_description) VALUES (?, ?)");
      $stmt->bindParam(1, $_POST['project_name'], PDO::PARAM_STR);
      $stmt->bindParam(2, $_POST['project_description'], PDO::PARAM_STR);
      $stmt->execute();
      $result = true;
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
    <h1>Create project</h1>
    <?php if($result): ?>
        <p>プロジェクトを登録しました。</p>
        <p><a href="/">TOPページへ</a></p>
    <?php else: ?>
        <form action="./create-project.php" method="post">
            <input type="text" name="project_name" placeholder="プロジェクト名">
            <input type="text" name="project_description" placeholder="プロジェクトの説明">
            <button type="submit">登録</button>
        </form>
    <?php endif ?>
</body>
</html>