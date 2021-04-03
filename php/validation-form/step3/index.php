<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'workshop');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '3306');

// エラー情報を表示する
// https://www.php.net/manual/ja/errorfunc.configuration.php#ini.error-reporting
ini_set('display_errors', "On");

// 出力する PHP エラーの種類を設定する
// https://www.php.net/manual/ja/function.error-reporting.php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

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

// エラーを格納する変数
$errors = [];

/**
 * 実行結果を保持する。
 * 未完了: false
 * 完了: true
 */
$result = false;

// POSTデータは$data変数にいれる
$data = [];
$data['user_name'] = !empty($_POST['user_name'])? $_POST['user_name'] : '';
$data['email'] = !empty($_POST['email'])? $_POST['email'] : '';
$data['password'] = !empty($_POST['password'])? $_POST['password'] : '';

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
      $stmt = $dbh->prepare("INSERT INTO users(user_name, email, password) VALUES (?,?,?)");
      $stmt->bindParam(1, $data['user_name'], PDO::PARAM_STR);
      $stmt->bindParam(2, $data['email'], PDO::PARAM_STR);
      $stmt->bindParam(3, password_hash($data['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
      $stmt->execute();
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
    <p class="success"><a href="./show.php">ユーザー一覧ページへ</a></p>
  <?php else: ?>
    <div class="bg-example">
      <form action="./index.php" method="post">
        <div class="form-group">
          <label for="exampleInputName">名前</label>
          <input 
            type="text"
            name="user_name"
            id="exampleInputName"
            placeholder="名前"
            class="<?php echo !empty($errors['user_name'])? 'error': 'ok'?>" 
            value="<?php echo $data['user_name'] ?>"
          >
        </div>
        <div class="form-group">
          <label for="exampleInputEmail">メールアドレス</label>
          <input 
            type="email" 
            name="email" 
            id="exampleInputEmail" 
            placeholder="メールアドレス" 
            class="<?php echo !empty($errors['email'])? 'error': 'ok'?>" 
            value="<?php echo $data['email'] ?>"
          >
          <p class="error" style="color:red"><?php echo $errors['email']?></p>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword">パスワード</label>
          <input 
            type="password"
            name="password" 
            id="exampleInputPassword" 
            placeholder="パスワード"
            class="<?php echo !empty($errors['password'])? 'error': 'ok'?>" 
            value="<?php echo $data['password'] ?>"
          >
        </div>
        <button type="submit">登録</button>
      </form>
    </div>
 
  <?php endif ?>
</body>

</html>
