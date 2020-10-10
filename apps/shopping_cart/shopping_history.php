<?php
session_start();
$shopping_history = $_SESSION['shopping_history'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>注文履歴</title>
</head>
<body>
<a href="/">TOPページへ</a>
<h1>注文履歴</h1>
  <?php if (empty($shopping_history)) : ?>
    <h1>お客様の購入履歴はありません。</h1>
  <?php else : ?>
    <?php foreach($shopping_history as $history):?>
      <?php foreach($history['items'] as $item):?>
        <p><?php echo $item['item_name'];?></p>
        <p>数量: <?php echo $item['item_count'];?></p>
        <p>注文日: <?php echo $history['purchase_time'];?></p>
      <?php endforeach; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</body>
</html>
