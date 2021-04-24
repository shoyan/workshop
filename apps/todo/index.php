<?php
    require_once("./database.php");
    $stmt = $dbh->prepare("SELECT * from projects;");
    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <ul>
        <li><a href="./create-project.php">create project</a></li>
    </ul>

    <h1>プロジェクト一覧</h1>
    <ul>
        <?php foreach($projects as $project): ?>
            <li><a href="./project.php?project_id=<?php echo $project['project_id']?>"><?php echo $project['project_name']?></a></li>
        <?php endforeach ?>
    </ul>
    
</body>
</html>