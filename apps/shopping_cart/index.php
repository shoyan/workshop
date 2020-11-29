<?php
// セッションを有効にする
session_start();

if (empty($_SESSION['shopping_cart'])) {
  $shoppingCart = [];
} else {
  $shoppingCart = $_SESSION['shopping_cart'];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ショッピングカートサンプル</title>
</head>
<body>
<a href="./shopping_history.php">注文履歴へ</a>

<p>
  <a href="./cart.php">カート(<?php echo count($shoppingCart) ?>)</a>
</p>

<div>
  <form action="./cart.php" method="post">
    <p>商品A</p>
    <input type="hidden" name="item_id" value="1">
    <input type="hidden" name="item_name" value="商品A">
    <input type="hidden" name="item_count" value="1">
    <input type="hidden" name="count_updated_method" value="add">
    <button type="submit">カートにいれる</button>
  </form>
</div>

 <div>
  <form action="./cart.php" method="post">
    <p>商品B</p>
    <input type="hidden" name="item_id" value="2">
    <input type="hidden" name="item_name" value="商品B">
    <input type="hidden" name="item_count" value="1">
    <input type="hidden" name="count_updated_method" value="add">
    <button type="submit">カートにいれる</button>
  </form>
</div>
  
</body>
</html>
