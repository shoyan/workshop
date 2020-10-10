<?php
session_start();
date_default_timezone_set('Asia/Tokyo');

// 注文履歴に追加する
$_SESSION['shopping_history'][] = [
  'purchase_time' => date("Y-m-d H:i:s"),
  'items' => $_SESSION['shopping_cart']
];
$_SESSION['shopping_cart'] = [];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<h1>ご購入ありがとうございました！</h1>
<p>商品の発送準備を行います。商品の到着までお待ちください。</p>

<a href="/">TOPページへ</a>
<a href="./shopping_history.php">注文履歴へ</a>

</body>
</html>
