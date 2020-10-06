<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>サンプルフォーム</title>
</head>

<body>
  <button type="button" class="btn btn-info " onclick="addTaskForm()">タスク行を追加する</button>
  <button type="button" class="btn btn-info " onclick="deleteTaskForm()">タスク行を削除する</button>

  <form action="" method="post">
    <div id="container"></div>
    <button type="submit">送信する</button>
  </form>

  <template id="template">
    <div class="form-inline">
      <div class="form-group">
        <input type="hidden" name="task_done[]" value="0">
        <input type="text" class="form-control" name="task_contents[]">
        <input type="date" class="form-control" name="task_deadline[]">
      </div>
      <div class="form-group">
        <div class="col-sm-1">
          <a href="/contact.html" class="btn"><i class="fab fa-twitter-square fa-2x"></i></a>
        </div>
      </div>
    </div>
  </template>

  <script>
    function addTaskForm() {
      // template要素を取得
      var template = document.querySelector('template');
      //template要素の内容を複製
      var template = template.content.cloneNode(true);
      // #containerの中に追加
      document.getElementById('container').appendChild(template);
    }

    function deleteTaskForm() {
      const container = document.getElementById('container');
      const last_child = container.querySelector(".form-inline:last-child");
      // 要素があれば削除する
      if (last_child) {
        document.getElementById('container').removeChild(last_child);
      }
    }
  </script>
</body>

</html>
