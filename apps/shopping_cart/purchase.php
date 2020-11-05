<?php
require_once('functions.php');
session_start();
date_default_timezone_set('Asia/Tokyo');

$errors = [];

// CSRF対策
$csrfToken = generateCsrfToken();
var_dump($_POST, $csrfToken, session_id());
if (empty($_POST['token']) || $_POST['token'] !== $csrfToken) {
  $errors[] = '不正な操作が行われました。もう一度、処理をやり直してください。';
}

// エラーがない場合は処理を行う
if (empty($errors)) {
  // 注文履歴に追加する
  $_SESSION['shopping_history'][] = [
    'purchase_time' => date("Y-m-d H:i:s"),
    'items' => $_SESSION['shopping_cart']
  ];
  $_SESSION['shopping_cart'] = [];
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

<?php if(!empty($errors)): ?>
  <h1>決済処理が正常に行われませんでした</h1>
  <ul class="error-box">
  <?php foreach($errors as $error): ?> 
    <li><?php echo $error; ?></li>
  <?php endforeach; ?> 
  </ul>
  <a href="/">TOPページへ</a>
<?php else: ?>
  <h1>ご購入ありがとうございました！</h1>
  <p>商品の発送準備を行います。商品の到着までお待ちください。</p>
  <a href="/">TOPページへ</a>
  <a href="./shopping_history.php">注文履歴へ</a>
<?php endif; ?>
</body>
</html>
