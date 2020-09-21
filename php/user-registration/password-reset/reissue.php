<?php
require_once('../init.php');

// パスワード再発行処理の完了フラグ
$success = false;
// 認証トークン
$tempPass = $_GET['token'];
// 認証トークンからユーザー情報を取得
$user = findUserByTempPass($dbh, $tempPass);
// ユーザーが存在しない場合は無効ページへ遷移
if (empty($user)) {
  header('location: ./disabled.php');
  exit;
}

// 認証トークンの有効期限切れチェック
$now = getUnixTimestamp(date("Y-m-d H:i:s"));
$tempPassLimitTimeUnixTimestamp = getUnixTimestamp($user['temp_pass_limit_time']);

// 認証トークンが期限切れの場合は無効ページへ遷移
if ($now > $tempPassLimitTimeUnixTimestamp) {
  header('location: ./disabled.php');
  exit;
}

// ユーザーが入力したパスワード
$password = $_POST['password'];
// 確認用のパスワード
$confirmPassword = $_POST['confirm_password'];
// エラーを格納する変数
$errors = [];

// 入力値が空
if (empty($password)) {
  $errors[] = 'パスワードを入力してください';
} 
// 入力値が空
if (empty($confirmPassword)) {
  $errors[] = '確認用のパスワードを入力してください';
}
//パスワード不一致
if ($password != $confirmPassword) {
  $errors[] = 'パスワードと確認用のパスワードが一致していません';
}

// エラーがない場合はパスワードを更新する
if (empty($errors)) {
  updateUserPassword($dbh, $user['id'], $password);
  // 処理完了フラグを立てる
  $success = true;
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>パスワードの再発行</title>
</head>

<body>

<?php if($success): ?>
  <div>
    <h1>パスワードリセット完了</h1>
    <p>パスワードのリセットが終了しました。</p>
    <p>ログイン画面からログインしてください。</p>
    <a href="/login.php">ログイン画面に戻る</a>
  </div>
<?php else: ?>
  <div>
    <h1>パスワードを入力してください</h1>

    <?php if(!empty($errors)): ?> 
      <ul class="error-box">
      <?php foreach($errors as $error): ?> 
        <li><?php echo $error; ?></li>
      <?php endforeach ?> 
      </ul>
    <?php endif ?>

    <form action="./reissue.php?token=<?php echo $tempPass; ?>" method="post">
      <div>
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password">
      </div>
      <div>
        <label for="confirm_password">パスワード(確認用)</label>
        <input type="password" name="confirm_password" id="confirm_password">
      </div>
      <button type="submit">パスワードを再設定する</button>
    </form>
  </div>
<?php endif ?>
</body>

</html>
