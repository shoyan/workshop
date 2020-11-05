<?php
// 関数名
// countArray

// 機能
// 引数として渡された配列のindex数を返す

// 引数
// 配列

// 戻り値
// 配列の数

[1,2,3]; 
function countArray($arr) {
  $num = count($arr);
  return $num;
}

echo countArray([1,2,3]);
