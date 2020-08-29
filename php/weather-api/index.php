<?php

// データを保持する配列
$data = [];

foreach($_GET['id'] as $id) {
  // urlを指定（city:千葉県）
  $base_url = "http://weather.livedoor.com/forecast/webservice/json/v1?city=" . $id;
  // APIを実行
  $json = file_get_contents($base_url, true);
  // 文字コードをUTF-8に変更
  $json = mb_convert_encoding($json, 'UTF-8');
  // 連想配列の形式で配列へ変換
  $data[] = json_decode($json, true);
}

// $base_date = $obj['forecasts'][0]['date']; // 2001-03-01
// $date_time = new DateTime($base_date);
// $week = array("日", "月", "火", "水", "木", "金", "土");
// $w = (int) $date_time->format('w');

// 日付を2015年05月14日（木）形式へ変換
// $base_date = $date_time->format('Y年m月d日') . "（" . $week[$w] . "）";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php foreach($data as $obj): ?>
  <h1><?php echo $obj['title']; ?></h1>

  <table border="1" width="500px">
    <tr>
      <td colspan="3" align="center"><b><?php echo $obj['forecasts'][0]['date']; ?></b></td>
    </tr>
    <tr>
      <td><?php echo $obj['forecasts'][0]['dateLabel']; ?></td>
      <td><?php echo "<img src='" . $obj['forecasts'][0]['image']['url']. "'>"; ?><?php echo $obj['forecasts'][0]['image']['title']; ?></td>
      <td><?php echo $obj['forecasts'][0]['temperature']['max']['celsius']; ?>℃ / <?php echo $obj['forecasts'][0]['temperature']['min']['celsius']; ?>℃</td>
    </tr>
    <tr>
      <td><?php echo $obj['forecasts'][1]['dateLabel']; ?></td>
      <td><?php echo "<img src='" . $obj['forecasts'][1]['image']['url']. "'>"; ?><?php echo $obj['forecasts'][1]['image']['title']; ?></td>
      <td><?php echo $obj['forecasts'][1]['temperature']['max']['celsius']; ?>℃ / <?php echo $obj['forecasts'][1]['temperature']['min']['celsius']; ?>℃</td>
    </tr>
    <tr>
      <td colspan="3"><b><?php echo $obj['description']['text']; ?></b></td>
    </tr>
  </table>

  <?php endforeach ?>

</body>

</html>
