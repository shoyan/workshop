<?php
// セッションを有効にする
session_start();

$shoppingCart = $_SESSION['shopping_cart'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ショッピングカートサンプル</title>
</head>
<body>
<p>
  <a href="./cart.php">カート(<?php echo count($shoppingCart) ?>)</a>
</p>

<div>
  <form action="./cart.php" method="post">
    <p>商品A</p>
    <input type="hidden" name="item_id" value="1">
    <input type="hidden" name="item_name" value="商品A">
    <input type="hidden" name="item_count" value="1">
    <button type="submit">カートにいれる</button>
  </form>
</div>

 <div>
  <form action="./cart.php" method="post">
    <p>商品B</p>
    <input type="hidden" name="item_id" value="2">
    <input type="hidden" name="item_name" value="商品B">
    <input type="hidden" name="item_count" value="1">
    <button type="submit">カートにいれる</button>
  </form>
</div>
  
</body>
</html>
