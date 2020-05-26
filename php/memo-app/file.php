<?php
// テストデータを作成するスクリプト

// データ保存先
$dataPath = dirname(__FILE__) . "/data/";

// 内容を作成
$file = $dataPath . 'a.json';
$content = [
  'title' => '今日の天気',
  'body' => '雨のち曇りです。',
];

// 結果をファイルに書き出します
file_put_contents($file, json_encode($content));

// 以下、同じ処理です

$file = $dataPath . 'b.json';
$content = [
  'title' => '明日の天気',
  'body' => '曇りのち晴れです。',
];
file_put_contents($file, json_encode($content));

$file = $dataPath . 'c.json';
$content = [
  'title' => '明後日の天気',
  'body' => '晴れのち曇りです。',
];
file_put_contents($file, json_encode($content));
