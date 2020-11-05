<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'workshop');
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

// データベースに登録
function create($dbh, $name, $price) {
  $stmt = $dbh->prepare("INSERT INTO bills (name,price) VALUES (?,?)");
  $data = [];
  $data[] = $name;
  $data[] = $price;
  $stmt->execute($data);
}

// データベースからデータを取得する
function selectAll($dbh) {
  $stmt = $dbh->prepare('SELECT * FROM bills ORDER BY updated_at DESC');
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function selectAllByUserId($dbh, $userId) {
  $stmt = $dbh->prepare('SELECT * FROM bills WHERE user_id = ? ORDER BY updated_at DESC');
  $data = [];
  $data[] = $userId;
  $stmt->execute($data);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (!empty($_POST)) {
  create($dbh, $_POST['name'], $_POST['price']);
}
if ($_GET['user_id']) {
  $result = selectAllByUserId($dbh, $_GET['user_id']);
} else {
  $result = selectAll($dbh);
}

$sum = 0;
foreach($result as $row) {
  $sum += $row['price'];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="./learnsql.php" method="post">
  <div>
    名前:
    <input type="text" name="name">
  </div>
  <div>
    料金:
    <input type="text" name="price">
  </div>
  <button type="submit">登録</button>
  </form>

  <form action="./learnsql.php" style="border: 1px solid black;">
  <div>
    ユーザーID: <input type="text" name="user_id">
    <button type="submit">送信</button>
  </div>
  
  </form>
  <?php foreach($result as $row): ?>
    <div>
    名前: <?php echo $row['name']; ?> 
    </div>
    <div>
    料金: <?php echo number_format($row['price'] * 1000) ; ?> 円
    </div>
    <div>
    ユーザーID: <?php echo $row['user_id']; ?> 
    </div>
  <?php endforeach ?> 
  <div>
    合計: <?php echo number_format($sum * 1000); ?> 円
  </div>
</body>
</html>
