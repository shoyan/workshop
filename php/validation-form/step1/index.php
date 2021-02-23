<?php
// エラーを格納する変数
$errors = [];

/**
 * 実行結果を保持する。
 * 未完了: false
 * 完了: true
 */
$result = false;

// POSTデータは$data変数にいれる
$data = $_POST;

// POSTリクエストの場合はバリデーションを実行する
if (!empty($_POST)) {
  if (empty($_POST['user_name'])) {
    $errors['user_name'] = '名前を入力してください。';
  }
  if (empty($_POST['email'])) {
    $errors['email'] = 'メールアドレスを入力してください。';
  }
  if (empty($_POST['password'])) {
    $errors['password'] = 'パスワードを入力してください。';
  }

  if (empty($errors)) {
      $result = true;
  }
}
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
  <h1>ユーザー登録</h1>
  <?php if(!empty($errors)): ?> 
    <ul class="error-box">
    <?php foreach($errors as $error): ?> 
      <li><?php echo $error; ?></li>
    <?php endforeach ?> 
    </ul>
  <?php endif ?>

  <?php if($result): ?>
    <p class="success">処理が完了しました。</p>
  <?php else: ?>
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
  <?php endif ?>
</body>

</html>
