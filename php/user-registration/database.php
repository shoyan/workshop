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
