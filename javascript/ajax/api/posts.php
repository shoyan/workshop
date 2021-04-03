<?php
$posts = [
    [
        'title' => 'はじめてのPHP',
        'content' => 'phpについての記事です。'
    ],
    [
        'title' => 'はじめてのJavaScript',
        'content' => 'JavaScriptについての記事です。'
    ],
    [
        'title' => 'はじめてのRuby',
        'content' => 'Rubyについての記事です。'
    ],
    [
        'title' => 'はじめてのJava',
        'content' => 'Javaについての記事です。'
    ],
    [
        'title' => 'はじめてのNode.js',
        'content' => 'Node.jsについての記事です。'
    ],
    [
        'title' => 'はじめてのHTML',
        'content' => 'HTMLについての記事です。'
    ],
    [
        'title' => 'はじめてのCSS',
        'content' => 'CSSについての記事です。'
    ],
];

// 一度に返すデータの個数
if (!empty($_GET['offset'])) {
    $offset = $_GET['offset'];
} else {
    $offset = 2;
}

// ページング
if (!empty($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// 取得するデータを計算
$start = $offset * ($page - 1);
// 必要なデータのみを取得
$data = array_slice($posts, $start, $offset);

header("Content-Type: application/json; charset=utf-8");
echo json_encode([
    "posts" => $data,
    'total_count' => count($posts)
]);