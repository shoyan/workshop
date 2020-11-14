<?php
require_once('init.php');

// idがない場合は404 Not Found
if (empty($_GET['id'])) {
    include_once('404.php');
    exit;
}

$postId = $_GET['id'];
$postData = null;
$comments = [];

// 記事の取得
if (!empty($postId)) {
    $postData = findPostById($postId);
}

// 記事データがない場合は404 Not Found
if (empty($postData)) {
    include_once('404.php');
    exit;
}

// コメント作成のリクエストの場合はコメントを作成する
if (!empty($postId) && !empty($_POST['comment'])) {
  createComment($postId, $_POST['comment']);
}

// コメントの取得
if (!empty($postData)) {
    $comments = findCommentsByPostId($postId);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $postData['post_title']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a href="/"><h1>マイブログ</h1></a>
<?php if(!empty($postData)): ?>
  <article>
  <h1><?php echo $postData['post_title']; ?></h1>
  <p><?php echo nl2br($postData['post_content']); ?></p>
  <p>投稿日：<?php echo $postData['created_at']; ?></p>
  </article>
<?php endif ?>

<?php if(!empty($comments)): ?>
  <section>
      <h2>コメント一覧</h2>
      <?php foreach($comments as $comment): ?>
          <section>
            <p><?php echo $comment['comment']; ?></p>
            <p><?php echo $comment['created_at']; ?></p>
          </section>
      <?php endforeach ?>
  </section>
<?php endif ?>

<section>
  <h2>コメントする</h2>
  <form action="./post.php?id=<?php echo $postId; ?>" method="post">
      <div>
          <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
      </div>
      <div>
          <button type="submit">コメントする</button>
      </div>
  </form>
</section>
</body>
</html>