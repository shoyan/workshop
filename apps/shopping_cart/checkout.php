<?php
session_start();
$checkout_items = $_SESSION['shopping_cart'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <a href="./cart.php">キャンセル</a>

  <?php if (empty($checkout_items)) : ?>
    <h1>お客様のショッピングカートに商品はありません。</h1>
  <?php else : ?>
    <?php foreach($checkout_items as $item):?>
      <p><?php echo $item['item_name'];?></p>
      <p>数量: <?php echo $item['item_count'];?></p>
    <?php endforeach; ?>
    <form action="./purchase.php">
      <button>注文を確定する</button>
    </form>
    <?php endif; ?>
</body>

</html>
