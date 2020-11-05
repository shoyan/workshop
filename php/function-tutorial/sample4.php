<?php
// 渡された文字列をすべて小文字と大文字にして返す

function upperAndLowerString($str) {
  return [
    'lower' => strtolower($str), 
    'upper' => strtoupper($str),
    'original' => $str,
    'length' => strlen($str),
  ];
}

print_r(upperAndLowerString("AbCdEf"));
// [
//   'lower' => 'abcdef', 
//   'upper' => 'ABCDEF',
//   'original' => 'AbCdEf',
//   'length' => 6,
// ];


