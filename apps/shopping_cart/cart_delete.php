<?php
// セッション開始
session_start();

$deleteItemId = $_GET['item_id'];

// 削除する商品IDがありショッピングカートに商品が登録されている場合
if (!empty($deleteItemId) && $_SESSION['shopping_cart']) {
  // 除外後の商品をいれる
  $shoppingCart = [];

  // ショッピングカートから削除する商品IDを検索し、あれば除外する
  foreach($_SESSION['shopping_cart'] as $item) {
    if ($item['item_id'] != $deleteItemId) {
      $shoppingCart[] = $item;
    }
  }

  // 除外後の商品で上書き
  $_SESSION['shopping_cart'] = $shoppingCart;
}

// cart.phpに遷移
header('location: cart.php');
