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
];

header("Content-Type: application/json; charset=utf-8");
echo json_encode($posts);