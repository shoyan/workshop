<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'workshop');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '3306');

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

$sql = 'SELECT * FROM users';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー認証機能</title>
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  <h1>ユーザー情報</h1>
    <?php foreach($result as $user): ?> 
      <p class="success">ユーザー名：<?php echo $user['user_name']; ?></p>
      <p class="success">メールアドレス：<?php echo $user['email']; ?></p>
    <?php endforeach ?> 
</body>

</html>
