<?php
// 渡された英字を全部大文字に変換する関数

// upperString("abcdef");
// => ABCDEF

function upperString($str) {
  return strtoupper($str);
}

echo upperString("abcdef");
