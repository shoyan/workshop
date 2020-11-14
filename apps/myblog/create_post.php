<?php
//　記事の投稿
require_once('./init.php');

if (!empty($_POST)) {
  $id = createPost($_POST['post_title'], $_POST['post_content']);
  header('Location: post.php?id=' . $id);
  exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>記事投稿</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="./create_post.php" method="post">
  <div>
    <input type="text" name="post_title" placeholder="タイトル">
  </div>
  <div>
    <textarea name="post_content" id="post_content" cols="30" rows="10"></textarea>
  </div>
  <div>
    <button type="submit">作成</button>
  </div>
</form>
</body>
</html>