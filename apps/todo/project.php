<?php
    require_once("./database.php");
    require_once("./functions.php");

    $stmt = $dbh->prepare("SELECT * from projects WHERE project_id = ?;");
    $stmt->bindParam(1, $_GET['project_id'], PDO::PARAM_INT);
    $stmt->execute();
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    $day1 = strtotime(date("Y-m-d"));
    $day2 = strtotime($project['project_end_date']);
    $project['days_left'] = ($day2 - $day1) / (60 * 60 * 24);

    $day1 = strtotime($project['project_begin_date']);
    $day2 = strtotime($project['project_end_date']);
    $project['origin_days_left'] = ($day2 - $day1) / (60 * 60 * 24);
    $project['days_left_ratio'] = 100 - floor($project['days_left'] / $project['origin_days_left'] * 100);

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
    foreach($categories as $index => $category) {
        $task_count = 0;
        $task_completed_count = 0;
        foreach ($categories[$index]['tasks'] as $task) {
            $task_count++;
            if ($task['task_completed']) {
                $task_completed_count++;
            }
        }
        $categories[$index]['task_progress_ratio'] = floor(($task_completed_count / $task_count) * 100);
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
        <li>プロジェクト名: <?php echo h($project['project_name']) ?></li>
        <li>概要: <?php echo h($project['project_description']) ?></li>
        <li>開始日: <?php echo h($project['project_begin_date']) ?></li>
        <li>終了日: <?php echo h($project['project_end_date']) ?></li>
        <li>残り日数: <?php echo h($project['days_left']) ?></li>
        <li>
            <label for="file">消化日数:</label>
            <progress id="file" max="100" value="<?php echo h($project['days_left_ratio'])?>"><?php echo h($project['days_left_ratio'])?>% </progress>
            <?php echo h($project['days_left_ratio'])?>%
        </li>
    </ul>

    <h2>カテゴリ</h2>
    <p><a href="./create-category.php?project_id=<?php echo h($project['project_id']) ?>">カテゴリ登録</a></p>

    <dl>
        <?php foreach($categories as $category): ?>
            <dt><a href="./category.php?category_id=<?php echo h($category['category_id']) ?>"><?php echo h($category['category_name']) ?></a>
                (<a href="./create-task.php?category_id=<?php echo h($category['category_id']) ?>">タスク登録</a>)
                <label for="file">進捗状況:</label>
                <progress id="file" max="100" value="<?php echo h($category['task_progress_ratio'])?>"><?php echo h($category['task_progress_ratio'])?>% </progress>
                <?php echo h($category['task_progress_ratio'])?>%
            </dt>
            <?php foreach($category['tasks'] as $task): ?>
            <dd>
                <?php echo h($task['task_name']) ?>
            </dd>
            <?php endforeach ?>
        <?php endforeach ?>
    </dl>

</body>
</html>