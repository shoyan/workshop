<?php
/**
 * PHPでデータを返却するAPI
 */
// Content-Typeをjson形式のフォーマットで明示的に指定する
header("Content-Type: application/json; charset=utf-8");
// CORS対策
header('Access-Control-Allow-Origin: *');

$data = [
    'id' => 1,
    'title' => 'Hello PHP'
];
// 連想配列をJSON形式の文字列に変換する
echo json_encode($data);