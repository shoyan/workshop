<?php 
session_start();
require_once("database.php");

function findUserByEmail($dbh, $email)
{
  $sql = 'SELECT * FROM users WHERE email = ?';
  $stmt = $dbh->prepare($sql);
  $data[] = $email;
  $stmt->execute($data);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!empty($_POST)) {
  $user = findUserByEmail($dbh, $_POST["email"]);

  if (password_verify($_POST["password"], $user["password"])) {
    // ログイン状態にする
    $_SESSION["login"] = true;
    $_SESSION["user"]  = $user; 
    header('Location: mypage.php');
    exit;
  } else {
    echo 'Invalid password.';
  }
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
<h1>ログイン</h1>
 <form action="./login.php" method="POST">
  <div>
    メールアドレス
    <input type="email" name="email"> 
    パスワード
    <input type="password" name="password"> 
    <button type="submit">ログイン</button>
  </div>
 </form> 
</body>
</html>
