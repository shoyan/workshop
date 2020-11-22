<?php
// アプリの初期処理
require_once('init.php');

// 現在のページ数取得
if (!empty($_GET['current'])) {
    $current = $_GET['current'];
} else {
    $current = 1;
}

// 1ページごとに表示する記事の件数
$limit = 2;
// 次に取得する記事のoffset
$offset = $limit * ($current - 1);
// 全記事の件数
$allPostCount = getAllPostCount();
// ページの件数を計算
$pageCount = ceil($allPostCount / $limit);
// 次のページがあれば変数に設定
if ($current < $pageCount) {
    $next = $current + 1;
}
// 前のページがあれば変数に設定
if ($current >= 2) {
    $prev = $current - 1;
}
// 投稿一覧を取得
$posts = findPosts($limit, $offset);

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
<div id ="content">
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
</div>

<div id="pagenation">
    <?php if(isset($prev)): ?>
        <a href="?current=<?php echo h($prev) ?>">前へ</a>
    <?php endif ?>
    <?php for($i = 1; $i <= $pageCount; $i++): ?>
        <?php if($i == $current): ?>
            <?php echo h($i) ?>
        <?php else: ?>
            <a href="?current=<?php echo h($i) ?>"><?php echo h($i) ?></a>
        <?php endif ?>
    <?php endfor ?>
    <?php if(isset($next)): ?>
        <a href="?current=<?php echo h($next) ?>">次へ</a>
    <?php endif ?>
</div>
</body>
</html>