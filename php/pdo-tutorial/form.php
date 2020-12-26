<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'tiny_memo');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '8889');

// 文字化け対策
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'");

// PHPのエラーを表示するように設定
error_reporting(E_ALL);

// データベースの接続
try {
  $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, $options);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}

// データベースに登録
function create($dbh, $title, $message) {
  $stmt = $dbh->prepare("INSERT INTO memo (title,message) VALUES (?,?)");
  $data = [];
  $data[] = $title;
  $data[] = $message;
  return $stmt->execute($data);
}

$result = false;
if (!empty($_POST)) {
  $result = create($dbh, $_POST["title"], $_POST["message"]);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メモ投稿</title>
  <style>
    .input-box {
      margin: 10px;
    }    
  </style>
</head>
<body>
  <?php if(!$result): ?>
    <form action="./form.php" method="post">
      <div class="input-box">
        <input type="text" name="title" value="" placeholder="タイトル" required>
      </div>
      <div class="input-box">
        <textarea name="message" cols="30" rows="10" placeholder="メッセージ" required></textarea>
      </div>
      <div class="input-box">
        <button type="submit">登録</button>
      </div>
    </form>
  <?php else: ?>
    <div>
      <p>メモの登録が完了しました。</p>
      <p><a href="./index.php">TOPへ戻る</a></p>
    </div>
  <?php endif ?>
</body>
</html>
