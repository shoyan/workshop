<?php

// urlを指定（city:千葉県）
$base_url = "http://weather.livedoor.com/forecast/webservice/json/v1?city=120010";

$json = file_get_contents($base_url, true);

$json = mb_convert_encoding($json, 'UTF-8');



// 連想配列の形式でjsonへ変換

$obj = json_decode($json, true);



$base_date = $obj['forecasts'][0]['date']; // 2001-03-01

$date_time = new DateTime($base_date);

$week = array("日", "月", "火", "水", "木", "金", "土");

$w = (int) $date_time->format('w');



// 日付を2015年05月14日（木）形式へ変換

$base_date = $date_time->format('Y年m月d日') . "（" . $week[$w] . "）";



$area = $obj['title']; // 島根県松江市の天気

$description = $obj['description']['text']; // 概況



// 今日の天気

$today_datelabel = $obj['forecasts'][0]['dateLabel']; // 今日

$today_img_url = $obj['forecasts'][0]['image']['url']; // 天気画像のurl

$today_weather = $obj['forecasts'][0]['image']['title']; // 晴れ

$today_max = $obj['forecasts'][0]['temperature']['max']['celsius']; // 最高気温

$today_min = $obj['forecasts'][0]['temperature']['min']['celsius']; // 最低気温



// 明日の天気

$tomorrow_datelabel = $obj['forecasts'][1]['dateLabel']; // 今日

$tomorrow_img_url = $obj['forecasts'][1]['image']['url']; // 天気画像のurl

$tomorrow_weather = $obj['forecasts'][1]['image']['title']; // 晴れ

$tomorrow_max = $obj['forecasts'][1]['temperature']['max']['celsius']; // 最高気温

$tomorrow_min = $obj['forecasts'][1]['temperature']['min']['celsius']; // 最低気温

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1><?php echo $area; ?></h1>

  <table border="1" width="500px">

    <tr>

      <td colspan="3" align="center"><b><?php echo $base_date; ?></b></td>

    </tr>

    <tr>

      <td><?php echo $today_datelabel; ?></td>

      <td><?php echo "<img src='" . $today_img_url . "'>"; ?><?php echo $today_weather; ?></td>

      <td><?php echo $today_max; ?>℃ / <?php echo $today_min; ?>℃</td>

    </tr>

    <tr>

      <td><?php echo $tomorrow_datelabel; ?></td>

      <td><?php echo "<img src='" . $tomorrow_img_url . "'>"; ?><?php echo $tomorrow_weather; ?></td>

      <td><?php echo $tomorrow_max; ?>℃ / <?php echo $tomorrow_min; ?>℃</td>

    </tr>

    <tr>

      <td colspan="3"><b><?php echo $description; ?></b></td>

    </tr>

  </table>

</body>

</html>
