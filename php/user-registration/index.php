<?php
session_start();
require_once("database.php");

$errors = [];

// データベースに登録
function userCreate($dbh, $userName, $email, $password)
{
  $stmt = $dbh->prepare("INSERT INTO users(user_name, email, password) VALUES (?,?,?)");
  $data = [];
  $data[] = $userName;
  $data[] = $email;
  $data[] = password_hash($password, PASSWORD_DEFAULT);
  $stmt->execute($data);
}

if (!empty($_POST)) {
  if (empty($_POST['user_name'])) {
    $errors[] = '名前を入力してください。';
  }
  if (empty($_POST['email'])) {
    $errors[] = 'メールアドレスを入力してください。';
  }
  if (empty($_POST['password'])) {
    $errors[] = 'パスワードを入力してください。';
  }

  if (empty($errors)) {
    userCreate($dbh, $_POST["user_name"], $_POST["email"], $_POST["password"]);
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー認証機能</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php include("menu.php"); ?>

  <h1>ユーザー登録</h1>
  <?php if(!empty($errors)): ?> 
    <ul class="error-box">
    <?php foreach($errors as $error): ?> 
      <li><?php echo $error; ?></li>
    <?php endforeach ?> 
    </ul>
  <?php endif ?>
  <div class="bg-example">
    <form action="./index.php" method="post">
      <div class="form-group">
        <label for="exampleInputName">名前</label>
        <input type="text" name="user_name" id="exampleInputName" placeholder="名前">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail">メールアドレス</label>
        <input type="email" name="email" id="exampleInputEmail" placeholder="メールアドレス">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword">パスワード</label>
        <input type="password" name="password" id="exampleInputPassword" placeholder="パスワード">
      </div>
      <button type="submit">登録</button>
    </form>
  </div>

</body>

</html>
