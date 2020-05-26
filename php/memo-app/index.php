<?php
  // データがあるパス
  $dataPath = dirname(__FILE__) . "/data/";

  // クエリにidがある場合はファイル内容を取得する
  if ($_GET['id']) {
    // 取得するファイルのパスを作成
    $filePath = $dataPath . $_GET['id'] . ".json";
    // 内容を読み込む
    $jsonString = file_get_contents($filePath);
    // json形式の文字列を配列で扱えるようにする
    $contents = json_decode($jsonString, true);
  } else {
    $contents = [];
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
  <h1>メモアプリ</h1>
  <ul>
    <li><a href="/?id=a">今日の天気</a></li>
    <li><a href="/?id=b">明日の天気</a></li>
    <li><a href="/?id=c">明後日の天気</a></li>
  </ul>

  <?php if (!empty($contents)): ?>
  <article>
    <h2><?php echo $contents['title']; ?></h2>
    <p><?php echo $contents['body']; ?></p>
  </article>
  <?php endif ?>
</body>

</html>
