<?php
    require_once("./database.php");
    require_once("./functions.php");

    $stmt = $dbh->prepare("SELECT * from categories WHERE category_id = ?;");
    $stmt->bindParam(1, $_GET['category_id'], PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST)) {
        if ($_POST['action'] === 'delete') {
            $stmt = $dbh->prepare("DELETE from categories WHERE category_id = ?;");
            $stmt->bindParam(1, $category['category_id'], PDO::PARAM_INT);
            $stmt->execute();
       } else {
            $stmt = $dbh->prepare("UPDATE categories SET category_name = ?, category_description = ? WHERE category_id = ?;");
            $stmt->bindParam(1, $_POST['category_name'], PDO::PARAM_STR);
            $stmt->bindParam(2, $_POST['category_description'], PDO::PARAM_STR);
            $stmt->bindParam(3, $category['category_id'], PDO::PARAM_INT);
            $stmt->execute();
        }
        // プロジェクトページに遷移させる
        header('Location: project.php?project_id=' . $category['project_id']);
   }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カテゴリ</title>
</head>
<body>
    <form action="./category.php?category_id=<?php echo h($category['category_id']) ?>" method="post">
        <input type="hidden" name="action" value="update">
        <input type="text" name="category_name" value="<?php echo h($category['category_name']) ?>">
        <input type="text" name="category_description" value="<?php echo h($category['category_description']) ?>">
        <button type="submit">更新</button>
    </form>

    <form action="./category.php?category_id=<?php echo h($category['category_id']) ?>" method="post">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="category_id" value="<?php echo h($category['category_id']) ?>">
        <button type="submit">削除する</button>
    </form>
</body>
</html>