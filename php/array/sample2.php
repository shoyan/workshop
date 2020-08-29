<?php
$fruits = [
  ['name' => 'リンゴ', 'color' => '赤'], 
  ['name' => 'ミカン', 'color' => 'オレンジ'],
  ['name' => 'バナナ', 'color' => '黄色']
];

foreach($fruits as $fruit) {
  echo $fruit['name'] . "\n";
  echo $fruit['color'] . "\n";
}
