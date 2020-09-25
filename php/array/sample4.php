<?php
/**
 * 特定のキーの情報を取得するサンプルコード 
 */

// 全データの中からキーがdoneの値を配列を取得
$data = [
  ['id' => 1, 'done' => 1, 'task' => 'タスク1'],
  ['id' => 2, 'done' => 1, 'task' => 'タスク2'],
  ['id' => 3, 'done' => 0, 'task' => 'タスク3'],
  ['id' => 4, 'done' => 1, 'task' => 'タスク4'],
  ['id' => 5, 'done' => 1, 'task' => 'タスク5'],
  ['id' => 6, 'done' => 1, 'task' => 'タスク6'],
];

// doneのみの値の配列を作成
$done_ids = array_column($data, 'done');

// done=1のデータを取得
$done_list = array_filter($data, function ($v) {
  return $v['done'] === 1;
});
echo "done_list" . PHP_EOL;
print_r($done_list);

// done=0のデータを取得
$undone_list = array_filter($data, function ($v) {
  return $v['done'] === 0;
});
echo "undone_list" . PHP_EOL;
print_r($undone_list);

if (empty($undone_list)) {
  echo 'done=0のデータはありません' . PHP_EOL;
} else {
  echo 'done=0のデータがあります' . PHP_EOL;
}
