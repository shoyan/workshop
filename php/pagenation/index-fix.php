<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

/**
 * 関数定義
 */

/**
 * 前のデータを取得する
 * @param  $current_id 現在のデータのid
 * @param  $data データ
 * @return array|null 前のデータ、存在しない場合はnull
*/
function getPrevData($current_id, $data) {
  // 現在のindexを取得
  $current_index = getCurrentIndex($current_id, $data);

  // indexが取得できない、もしくは0の時は前のデータがないとみなす
  if (!$current_index) {
    return null;
  }

  // 現在のデータの前のindexを計算
  $prev_index = $current_index - 1;

  // 前のデータを返す
  return $data[$prev_index];
}

/**
 * 次のデータのURLを取得する
 * @param  $current_id 現在のデータのid
 * @param  $data データ
 * @return array|null 次のデータ、存在しない場合はnull
*/
function getNextData($current_id, $data) {
  // 現在のindexを取得
  $current_index = getCurrentIndex($current_id, $data);
  // 全データの数を取得
  $data_count = count($data);

  // 現在のindexが取得できない場合はnullを返す
  if ($current_index === false) {
    return null;
  }

  // 次のページのidを取得　※次のキーがデータの最大件数以上の場合は次のデータは存在しないのでnullを返す
  if ($current_index + 1 >= $data_count) {
    return null;
  }

  // 現在のデータの次のindexを計算
  $next_index = $current_index + 1;

  // 次のデータを返す
  return $data[$next_index];
}

/**
 * 現在のデータのindexを取得する
 * @param  $id 現在のURLパラメータの数値（/?id=●●●）
 * @param $testData データ
 * @return integer 現在のindex
*/
function getCurrentIndex($id, $testData) {
  // 全データの中からキーがidの値を配列を取得
  $testData_idArr = array_column($testData, 'id');

  // $testData_idArr配列から現在のページのid値と一致するキーを取得＝現在のキーを取得
  $current_index = array_search($id, $testData_idArr);

  return $current_index;
}

/**
 * ここからが実際の処理
 */

// 現在のデータのidを取得
$getId = intval($_GET['id']);

// ＤＢの全データを取得（仮）
$testData = array(
  array('id' => '2', 'title' => '1個目のデータのタイトルです'),  // 0
  array('id' => '3', 'title' => '2個目のデータのタイトルです'),  // 1
  array('id' => '5', 'title' => '3個目のデータのタイトルです'),  // 2
  array('id' => '6', 'title' => '4個目のデータのタイトルです'),  // 3
  array('id' => '7', 'title' => '5個目のデータのタイトルです'),  // 4
  array('id' => '8', 'title' => '6個目のデータのタイトルです'),  // 5
  array('id' => '9', 'title' => '7個目のデータのタイトルです'),  // 6
);

// 前のページのデータを取得
$prevData = getPrevData($getId, $testData);
// 次のページのデータを取得
$nextData = getNextData($getId, $testData);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ページネーションのサンプル</title>
</head>
<body>

  <?php if (!empty($prevData)) : ?>
    <a href="./index-fix.php?id=<?php echo $prevData['id']; ?>">前へ</a>
  <?php else : ?>
    前へ
  <?php endif; ?>

  <?php if (!empty($nextData)) : ?>
    <a href="./index-fix.php?id=<?php echo $nextData['id']; ?>">次へ</a>
  <?php else : ?>
    次へ
  <?php endif; ?>

</body>
</html>
