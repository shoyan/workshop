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
            <li>
                <input type="checkbox" name="deleted_project">
                <a href="./project.php?project_id=<?php echo $project['project_id']?>"><?php echo $project['project_name']?></a></li>
        <?php endforeach ?>
    </ul>
    <p id="project_selected">selected: <span>0</span></p>

    <script>
        // 選択数を表示する要素を取得
        const projectSelectedElement = document.querySelector("#project_selected span");
        // checkboxの1つ1つにイベントを設定
        document.querySelectorAll("input[name='deleted_project']").forEach(function(checkbox) {
            // checkboxのチェックを入れる or 外すと処理が実行される
            checkbox.addEventListener('change', function() {
                // checkboxのチェックされている数を更新
                projectSelectedElement.textContent = document.querySelectorAll("input[name='deleted_project']:checked").length
            })
        })
    </script>
</body>
</html>