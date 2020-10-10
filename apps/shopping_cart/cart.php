<?php
// セッションを有効にする
session_start();

// POSTデータがあればショッピングカートに登録する
if (!empty($_POST)) {
  // 登録する商品情報の作成
  $postedItem = [
    'item_id' => $_POST['item_id'],
    'item_name' => $_POST['item_name'],
    'item_count' => $_POST['item_count'],
  ];

  // ショッピングカートが空の場合
  if (empty($_SESSION['shopping_cart'])) {
    // POSTされた商品を登録する
    $_SESSION['shopping_cart'] = [];
    $_SESSION['shopping_cart'][] = $postedItem;
  // ショッピングカートが空でない場合
  } else {
    // ショッピングカートに登録するフラグ　
    // trueの場合はショッピングカートに追加
    $register = true;

    // ショッピングカート内に同じ商品がないかを検索する。あれば上書きする
    foreach ($_SESSION['shopping_cart'] as $index => $item) {
      if ($item['item_id'] == $postedItem['item_id']) {
        // count_updated_method=addの場合は件数を追加する
        if (isset($_POST['count_updated_method']) && $_POST['count_updated_method'] === 'add') {
          $postedItem['item_count'] += $item['item_count'];
        }
        // 商品を上書きする
        $_SESSION['shopping_cart'][$index] = $postedItem;

        // すでに同じ商品がショッピングカートに登録済み
        // 追加する必要がないのでfalseにする
        $register = false;
      }
    }

    // 登録フラグがたっていればショッピングカートに登録する
    if ($register) {
      $_SESSION['shopping_cart'][] = $postedItem;
    }
  }
}

$items = $_SESSION['shopping_cart'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ショッピングカート</title>
</head>

<body>
  <a href="./">お買い物を続ける</a>
  <h1>ショッピングカート</h1>

  <?php if (empty($items)) : ?>
    <h1>お客様のショッピングカートに商品はありません。</h1>
  <?php else : ?>
    <?php foreach ($items as $item) : ?>
      <div>
        <p>
          <form action="./cart.php" method="post">
            <input type="hidden" name="item_id" value="<?php echo $item['item_id'] ?>">
            <input type="hidden" name="item_name" value="<?php echo $item['item_name'] ?>">
            <input type="hidden" name="item_count" value="<?php echo $item['item_count'] ?>">

            <?php echo $item['item_name']; ?>
            <select name="item_count" class="change_item_count">
              <option value="1" <?php echo $item['item_count'] == '1' ? 'selected' : '' ?>>数量:1</option>
              <option value="2" <?php echo $item['item_count'] == '2' ? 'selected' : '' ?>>数量:2</option>
              <option value="3" <?php echo $item['item_count'] == '3' ? 'selected' : '' ?>>数量:3</option>
              <option value="4" <?php echo $item['item_count'] == '4' ? 'selected' : '' ?>>数量:4</option>
              <option value="5" <?php echo $item['item_count'] == '5' ? 'selected' : '' ?>>数量:5</option>
            </select>
          </form>
          <a href="./cart_delete.php?item_id=<?php echo $item['item_id'] ?>">削除</a>
        </p>
      </div>
    <?php endforeach ?>
    <a href="./checkout.php"><button>レジに進む</button></a>
  <?php endif ?>


  <script>
    // 数量が変更されたら更新を行う
    const itemCounts = document.querySelectorAll('.change_item_count');
    itemCounts.forEach(function(elem) {
      elem.addEventListener('change', function(elem) {
        const form = elem.target.parentNode;
        form.querySelector('input[name="item_count"]').value = elem.target.value
        form.submit();
      });
    });
  </script>
</body>

</html>
