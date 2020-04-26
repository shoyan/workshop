<?php
session_start();
if (!$_SESSION["login"]) {
  header('Location: login.php');
  exit;
}
$user = $_SESSION["user"];

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
<h1>マイページ</h1>
<p>ユーザー名: <?php echo $user["user_name"]; ?></p>
</body>
</html>
