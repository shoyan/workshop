<?php
    require_once("./database.php");
    /**
     * プロジェクトIDに紐づくカテゴリを取得する
     */
    function get_categories_by_project_id($project_id) {
        global $dbh;
        $stmt = $dbh->prepare("SELECT * from categories WHERE project_id = ?;");
        $stmt->bindParam(1, $project_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * カテゴリIDに紐づくタスクを全て削除する
     */
    function delete_all_task_by_category_id($category_id) {
        global $dbh;
        $stmt = $dbh->prepare("DELETE from tasks WHERE category_id = ?;");
        $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * カテゴリを削除する
     */
    function delete_category_by_category_id($category_id) {
        global $dbh;
        $stmt = $dbh->prepare("DELETE from categories WHERE category_id = ?;");
        $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * プロジェクトを削除する
     */
    function delete_project_by_project_id($project_id) {
        global $dbh;
        $stmt = $dbh->prepare("DELETE from projects WHERE project_id = ?;");
        $stmt->bindParam(1, $project_id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    // deleted_project_idがあれば削除を実施
    if (!empty($_POST['deleted_project_id'])) {
        foreach($_POST['deleted_project_id'] as $project_id) {
            // プロジェクトに紐づくカテゴリを取得
            $categories = get_categories_by_project_id($project_id);
            foreach($categories as $category) {
                // タスクを削除
                delete_all_task_by_category_id($category['category_id']);
                // カテゴリを削除
                delete_category_by_category_id($category['category_id']);
            }
            // プロジェクトを削除
            delete_project_by_project_id($project_id);
        }
    }

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
    <form action="index.php" method="post">
      <ul>
          <?php foreach($projects as $project): ?>
              <li>
                  <input type="checkbox" name="deleted_project_id[]" value="<?php echo $project['project_id']?>">
                  <a href="./project.php?project_id=<?php echo $project['project_id']?>"><?php echo $project['project_name']?></a></li>
          <?php endforeach ?>
      </ul>
    <p id="project_selected">selected: <span>0</span>
        <button type="submit">削除</button>
    </p>
    </form>
    <script>
        // 選択数を表示する要素を取得
        const projectSelectedElement = document.querySelector("#project_selected span");
        // checkboxの1つ1つにイベントを設定
        document.querySelectorAll("input[name='deleted_project_id']").forEach(function(checkbox) {
            // checkboxのチェックを入れる or 外すと処理が実行される
            checkbox.addEventListener('change', function() {
                // checkboxのチェックされている数を更新
                projectSelectedElement.textContent = document.querySelectorAll("input[name='deleted_project_id']:checked").length
            })
        })
    </script>
</body>
</html>