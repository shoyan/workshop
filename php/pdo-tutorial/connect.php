<?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);

$user = 'root';
$pass = 'root';

try {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=workshop;port=8889', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // foreach($dbh->query('SELECT * from users') as $row) {
    //     print_r($row);
    // }
} catch (PDOException $e) {
    print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}
// データの登録
// try {
//     $stmt = $dbh->prepare("INSERT INTO users(user_name, email, password) VALUES (?,?,?)");
//     $data = [];
//     $data[] = '太郎';
//     $data[] = 'taro@taro.com';
//     $data[] = 'taro';
//     $stmt->execute($data);
// } catch (PDOException $e) {
//     print "エラー!: " . $e->getMessage() . "<br/>";
//     die();
// }

try {
  $stmt = $dbh->prepare("INSERT INTO users (name, age, gender, email, tel, height, weight) VALUES (?,?,?,?,?,?,?)");
  print_r($dbh->errorInfo());
  $data = [];
  $data[] = '太郎';
  $data[] = '30';
  $data[] = '男';
  $data[] = 'taro@taro.com';
  $data[] = '090-000-0000';
  $data[] = '181';
  $data[] = '78';
  $result = $stmt->execute($data);
} catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/>";
  die();
}


// データ削除
// $sql = 'DELETE FROM users WHERE id = ?';
// $stmt = $dbh->prepare($sql);
// $data[] = '17';
// $stmt->execute($data);


?>
