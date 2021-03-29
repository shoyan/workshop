<?php
/**
 * 配列のデータ数を数える関数
 * @param $arr 対象の配列
 * @return 配列のデータ数
 */
function countArray($arr) {
  $num = count($arr);
  return $num;
}

echo countArray([1,2,3]);
