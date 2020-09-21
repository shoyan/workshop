<?php
/**
 * パスワード再発行処理のURLを作成して送付する
 */
require_once('../init.php');

// エラー情報を格納する変数
$errors = [];
// パスワード再発行用のURLを送信するメールアドレス
$mail = $_POST["email"];

// メールアドレスが存在すればパスワード再発行用の処理を行う
if (!empty($mail)) {
  // 入力されたメールアドレスからユーザー情報を取得
  $user = findUserByEmail($dbh, $mail);

  if (empty($user)) {
    $errors[] = '入力されたメールアドレスが存在しません。';
  }

  // エラーが存在しなければパスワード再発行用のURLを送信する
  if (empty($errors)) {
    // パスワード再発行の認証トークンを発行する
    $tempPass = getResetPassword();
    // 認証トークンの期限を取得する
    $tempPassLimitTime = getTempPassLimitTime();

    // データベースに認証トークンを登録する
    updateUserTempPass($dbh, $user['id'], $tempPass, $tempPassLimitTime);
  
    // メール送信
    define('SENDER_EMAIL', 'admin@localhost');
    // メールヘッダーインジェクション対策
    $mail = str_replace(array('\r\n', '\r', '\n'), '', $mail);
    $url = 'http://localhost:8080/password-reset/reissue.php?token=' . $tempPass; 
    $msg = '以下のアドレスからパスワードのリセットを行ってください。' . PHP_EOL;
    $msg .= 'アドレスの有効時間は60分間です。' . PHP_EOL . PHP_EOL;
    $msg .= $url;
    mb_send_mail($mail, 'パスワードの再発行', $msg, ' From :  ' . SENDER_EMAIL);

    // 完了ページに遷移する
    header('location: /password-reset/accept.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>パスワード再発行</title>
</head>

<body>
  <div>
    <h1>パスワードをお忘れですか？</h1>

    <?php if(!empty($errors)): ?> 
      <ul class="error-box">
      <?php foreach($errors as $error): ?> 
        <li><?php echo $error; ?></li>
      <?php endforeach ?> 
      </ul>
    <?php endif ?>

    <form action="./index.php" method="post">
      <p>アカウントに関連付けられているEメールアドレスを入力してください。パスワード再設定のメールが送信されます。</p>
      <label for="email">Eメールアドレス</label>
      <input type="text" name="email" id="email">
      <button type="submit">送信する</button>
    </form>
  </div>
</body>

</html>
