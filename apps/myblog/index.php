<?php
// アプリの初期処理
require_once('init.php');

// 投稿一覧を取得
$posts = getAllPosts();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイブログ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>マイブログ</h1>
<a href="./create_post.php">新規作成</a>

<h2>投稿一覧</h2>
<?php foreach($posts as $post): ?>
<section>
    <a href="./post.php?id=<?php echo h($post['id']); ?>"><h3><?php echo h($post['post_title']); ?></h3></a>
    <p><?php echo h($post['post_content']); ?></p>
    <p><?php echo h($post['created_at']); ?></p>
</section>
<?php endforeach ?>
</body>
</html>