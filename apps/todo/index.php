<?php
    require_once("./database.php");
    require_once("./functions.php");

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

    // 削除ボタンを押された場合（単体削除）
    if (!empty($_GET['deleted'])) {
        // プロジェクトに紐づくカテゴリを取得
        $categories = get_categories_by_project_id($_GET['project_id']);
        foreach($categories as $category) {
            // タスクを削除
            delete_all_task_by_category_id($category['category_id']);
            // カテゴリを削除
            delete_category_by_category_id($category['category_id']);
        }
        // プロジェクトを削除
        delete_project_by_project_id($_GET['project_id']);
    }

    // プロジェクト一覧を取得する
    $projects = get_all_projects();
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
                  <a href="./project.php?project_id=<?php echo $project['project_id']?>"><?php echo $project['project_name']?></a>
                  <a href="./index.php?project_id=<?php echo $project['project_id']?>&deleted=1">削除</a>
                </li>
          <?php endforeach ?>
      </ul>
      <div>
          <input type="checkbox" name="all_selected" id="all_selected">
          <label for="all_selected">まとめて選択</label>
      </div>
    <p id="project_selected">selected: <span>0</span>
        <button type="submit">削除</button>
    </p>
    </form>
    <script>
        // 選択数を表示する要素を取得
        const projectSelectedElement = document.querySelector("#project_selected span");
        // checkboxの1つ1つにイベントを設定
        document.querySelectorAll("input[name='deleted_project_id[]']").forEach(function(checkbox) {
            // checkboxのチェックを入れる or 外すと処理が実行される
            checkbox.addEventListener('change', function() {
                // checkboxのチェックされている数を更新
                projectSelectedElement.textContent = document.querySelectorAll("input[name='deleted_project_id[]']:checked").length
            })
        })

        const allSelected = document.querySelector('#all_selected');
        allSelected.addEventListener('change', function(checkbox) {
            document.querySelectorAll("input[name='deleted_project_id[]']").forEach(function(childCheckbox) {
                if (checkbox.target.checked) {
                    childCheckbox.checked = true;
                } else {
                    childCheckbox.checked = false;
                }
            })
            // checkboxのチェックされている数を更新
            projectSelectedElement.textContent = document.querySelectorAll("input[name='deleted_project_id[]']:checked").length
        })
    </script>
</body>
</html>