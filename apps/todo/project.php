<?php
    require_once("./database.php");

    $stmt = $dbh->prepare("SELECT * from projects WHERE project_id = ?;");
    $stmt->bindParam(1, $_GET['project_id'], PDO::PARAM_INT);
    $stmt->execute();
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $dbh->prepare("SELECT * from categories WHERE project_id = ?;");
    $stmt->bindParam(1, $_GET['project_id'], PDO::PARAM_INT);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($categories as $index => $category) {
        $stmt = $dbh->prepare("SELECT * from tasks WHERE category_id = ?;");
        $stmt->bindParam(1, $category['category_id'], PDO::PARAM_INT);
        $stmt->execute();
        $categories[$index]['tasks'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <a href="/">TOPページ</a>
    <h1>プロジェクト詳細</h1>
    <ul>
        <li>プロジェクト名: <?php echo $project['project_name'] ?></li>
        <li>概要: <?php echo $project['project_description'] ?></li>
    </ul>

    <h2>カテゴリ</h2>
    <p><a href="./create-category.php?project_id=<?php echo $project['project_id'] ?>">カテゴリ登録</a></p>

    <dl>
        <?php foreach($categories as $category): ?>
            <dt><a href="./category.php?category_id=<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></a>
                (<a href="./create-task.php?category_id=<?php echo $category['category_id'] ?>">タスク登録</a>)
            </dt>
            <?php foreach($category['tasks'] as $task): ?>
            <dd>
                <?php echo $task['task_name'] ?>
            </dd>
            <?php endforeach ?>
        <?php endforeach ?>
    </dl>

</body>
</html>