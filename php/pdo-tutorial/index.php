<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'tiny_memo');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '8889');

// 文字化け対策
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'");

// PHPのエラーを表示するように設定
error_reporting(E_ALL & ~E_NOTICE);

// データベースの接続
try {
  $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, $options);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}

// データベースからデータを取得する
function selectAll($dbh) {
  $stmt = $dbh->prepare('SELECT * FROM memo ORDER BY updatedAt DESC');
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$result = selectAll($dbh);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>メモ一覧</h1>
  <p><a href="./form.php">メモの登録</a></p>
  <?php if (!empty($result)): ?>
    <?php foreach($result as $row): ?>
     <div><?php echo "title: " . $row["title"]; ?></div>
     <div><?php echo "message: " . $row["message"]; ?></div>
    <?php endforeach ?> 
 <?php else: ?>
  <p>まだメモは登録されていません。</p>
  <?php endif ?>
 </body>
</html>
