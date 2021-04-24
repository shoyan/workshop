<?php
    require_once("./database.php");
    $result = false;
    if (!empty($_POST)) {
      $stmt = $dbh->prepare("INSERT INTO categories(project_id, category_name, category_description) VALUES (?, ?, ?)");
      $stmt->bindParam(1, $_GET['project_id'], PDO::PARAM_STR);
      $stmt->bindParam(2, $_POST['category_name'], PDO::PARAM_STR);
      $stmt->bindParam(3, $_POST['category_description'], PDO::PARAM_STR);
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
    <title>カテゴリ登録</title>
</head>
<body>
    <h1>カテゴリ登録</h1>
    <?php if ($result): ?>
        <p>カテゴリ登録が完了しました。</p>
        <p><a href="./project.php?project_id=<?php echo $_GET['project_id'] ?>">プロジェクトページ</a></p>
    <?php else: ?>
        <form action="./create-category.php?project_id=<?php echo $_GET['project_id'] ?>" method="post">
            <input type="text" name="category_name" placeholder="カテゴリ名">
            <input type="text" name="category_description" placeholder="カテゴリ概要">
            <button type="submit">登録</button>
        </form>
    <?php endif ?>
</body>
</html>