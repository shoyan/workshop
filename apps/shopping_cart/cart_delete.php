<?php
// セッション開始
session_start();

$deleteItemId = $_GET['item_id'];
if (!empty($deleteItemId) && $_SESSION['shopping_cart']) {
  $shoppingCart = [];
  foreach($_SESSION['shopping_cart'] as $item) {
    if ($item['item_id'] != $deleteItemId) {
      $shoppingCart[] = $item;
    }
  }
  $_SESSION['shopping_cart'] = $shoppingCart;
}

header('location: cart.php');
