<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'crud-api');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '3306');

// 文字化け対策
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'");

// PHPのエラーを表示するように設定
// error_reporting(E_ALL);

/**
 * PHPでデータを返却するAPI
 */
// Content-Typeをjson形式のフォーマットで明示的に指定する
header("Content-Type: application/json; charset=utf-8");
// CORS対策
header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_METHOD'] === "OPTIONS" && isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
	// GET, POST, OPTIONS の場合はAllow-Methodsヘッダは不要
	header('Access-Control-Allow-Methods: GET, POST');
	// 許可するヘッダ (必要なら)
	header('Access-Control-Allow-Headers: Content-Type, Authorization');
	// Cookie送信などのCredential情報をやり取りする場合 (必要なら)
	header('Access-Control-Allow-Credentials: true');
	// preflightリクエストをキャッシュする時間 [秒]
	header('Access-Control-Max-Age: 60');
	exit;
}

if (empty($_POST['body'])) {
  // ステータスコードをBad Requestにする
  http_response_code(400);

  echo json_encode([
      'error' => 'body is required.',
  ]);
  exit;
}

// データベースの接続
try {
  $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, $options);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  // 連想配列をJSON形式の文字列に変換する
  echo json_encode([
      'error' => $e->getMessage(),
  ]);
  exit;
}
$body = $_POST['body'];
// データベースに登録
$stmt = $dbh->prepare("INSERT INTO memo (body) VALUES (?)");
$stmt->bindValue(1, $body, PDO::PARAM_STR);

try {
  $stmt->execute();
} catch(PDOException $e) {
  echo json_encode([
      'error' => $e->getMessage(),
  ]);
  exit;
}

// 連想配列をJSON形式の文字列に変換する
echo json_encode([
  'id' => $dbh->lastInsertId(),
  'body' => $body
]);