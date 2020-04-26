<?php 
session_start();
require_once("database.php");
// データベースに登録
function userCreate($dbh, $userName, $email, $password) {
  $stmt = $dbh->prepare("INSERT INTO users(user_name, email, password) VALUES (?,?,?)");
  $data = [];
  $data[] = $userName;
  $data[] = $email;
  $data[] = password_hash($password, PASSWORD_DEFAULT);
  $stmt->execute($data);
}

if (!empty($_POST)) {
  userCreate($dbh, $_POST["user_name"], $_POST["email"], $_POST["password"]);
}
if ($_SESSION["login"]) {
  echo "ログインしています。";
} else {
  echo "ログインしていません。";
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
<?php include("menu.php"); ?> 

<h1>ユーザー登録</h1>
<form action="./index.php" method="post">
  <div>
    名前
    <input type="text" name="user_name">
  </div>
  <div>
    メールアドレス
    <input type="email" name="email">
  </div>
  <div>
    パスワード
    <input type="password" name="password">
  </div>
  <button type="submit">登録</button>
</form>
  
</body>
</html>
