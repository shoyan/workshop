<?php
$items = [];
array_push($items, [
 'image_url' => "https://m.media-amazon.com/images/I/61xv+1pUBrL._AC_UL640_FMwebp_QL65_.jpg",
 'title' => 'PHPフレームワークLaravel入門 第2版',
 'price' => 3300,
]);
array_push($items, [
 'image_url' => "https://m.media-amazon.com/images/I/81OOlBrnnYL._AC_UL640_FMwebp_QL65_.jpg",
 'title' => 'いきなりはじめるPHP~ワクワク・ドキドキの入門教室~',
 'price' => 1980,
]);
array_push($items, [
 'image_url' => "https://m.media-amazon.com/images/I/71GIXyKmSVL._AC_UL640_FMwebp_QL65_.jpg",
 'title' => '気づけばプロ並みPHP 改訂版--ゼロから作れる人になる!',
 'price' => 2970,
]);
array_push($items, [
 'image_url' => "https://m.media-amazon.com/images/I/81K4gIQYhZL._AC_UL640_FMwebp_QL65_.jpg",
 'title' => 'PHP本格入門[上] ~プログラミングとオブジェクト指向の基礎からデータベース連携まで',
 'price' => 3938,
]);
array_push($items, [
 'image_url' => "https://m.media-amazon.com/images/I/61xv+1pUBrL._AC_UL640_FMwebp_QL65_.jpg",
 'title' => 'PHPフレームワークLaravel入門 第2版',
 'price' => 3300,
]);
array_push($items, [
 'image_url' => "https://m.media-amazon.com/images/I/81OOlBrnnYL._AC_UL640_FMwebp_QL65_.jpg",
 'title' => 'いきなりはじめるPHP~ワクワク・ドキドキの入門教室~',
 'price' => 1980,
]);
array_push($items, [
 'image_url' => "https://m.media-amazon.com/images/I/71GIXyKmSVL._AC_UL640_FMwebp_QL65_.jpg",
 'title' => '気づけばプロ並みPHP 改訂版--ゼロから作れる人になる!',
 'price' => 2970,
]);
array_push($items, [
 'image_url' => "https://m.media-amazon.com/images/I/81K4gIQYhZL._AC_UL640_FMwebp_QL65_.jpg",
 'title' => 'PHP本格入門[上] ~プログラミングとオブジェクト指向の基礎からデータベース連携まで',
 'price' => 3938,
]);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    .container {
      display: flex;
      flex-wrap: wrap;
    }
    .item-box {
      width: 300px;
      border: 1px solid #999;
      padding: 20px;
      margin: 10px;
    }
    .item-box img {
      width: 250px;
      margin: 0 auto;
      display: block;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php foreach($items as $item): ?>
    <div class="item-box">
      <div>
        <img src="<?php echo $item['image_url'] ?>" alt="">
      </div>
      <p><?php echo $item['title'] ?></p>
      <p>¥<?php echo number_format($item['price']) ?></p>
    </div>
    <?php endforeach ?>

  </div>
</body>
</html>
