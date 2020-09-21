<?php
session_start();
require_once("database.php");
require_once("function.php");

$errors = [];
if (!empty($_POST)) {
  $user = findUserByEmail($dbh, $_POST["email"]);

  if (password_verify($_POST["password"], $user["password"])) {
    // ログイン状態にする
    $_SESSION["login"] = true;
    $_SESSION["user"]  = $user;
    header('Location: mypage.php');
    exit;
  } else {
    $errors[] = 'メールアドレスまたはパスワードに誤りがあります。';
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
  <h1>ログイン</h1>

  <?php if(!empty($errors)): ?> 
    <ul class="error-box">
    <?php foreach($errors as $error): ?> 
      <li><?php echo $error; ?></li>
    <?php endforeach ?> 
    </ul>
  <?php endif ?>

  <div class="bg-example">
    <form action="./login.php" method="POST">

      <div class="form-group">
        
        <label for="exampleInputEmail">メールアドレス</label>
        <input type="email" name="email" id="exampleInputEmail" value="<?php echo $_POST['email']?>" required>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword">パスワード</label>
        <input type="password" name="password" id="exampleInputPassword" required>
      </div>
        <button type="submit">ログイン</button>
    </form>
  </div>
</body>

</html>
