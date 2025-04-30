<?php
// shorten.php

header('Content-Type: application/json');

// DB接続情報
$config = require __DIR__ . '/config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], $options);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB接続に失敗しました']);
    exit;
}

// 入力値取得
$input = json_decode(file_get_contents('php://input'), true);
$originalUrl = trim($input['original_url'] ?? '');
$password = $input['password'] ?? null;
$expiresAt = $input['expires_at'] ?? null;

if (empty($originalUrl)) {
    http_response_code(400);
    echo json_encode(['error' => 'URLは必須です']);
    exit;
}

// パスワードをハッシュ化（未入力ならnull）
$passwordHash = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : null;

// 有効期限フォーマットチェック（Y-m-d H:i:s）
$expiresAtSql = null;
if (!empty($expiresAt)) {
    $timestamp = strtotime($expiresAt);
    if ($timestamp === false) {
        http_response_code(400);
        echo json_encode(['error' => '有効期限の形式が正しくありません']);
        exit;
    }
    $expiresAtSql = date('Y-m-d H:i:s', $timestamp);
}

// ランダムなshort_code生成（6文字）
function generateShortCode($length = 6)
{
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

// 重複を避けるために確認ループ
do {
    $shortCode = generateShortCode();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM short_urls WHERE short_code = ?");
    $stmt->execute([$shortCode]);
    $exists = $stmt->fetchColumn() > 0;
} while ($exists);

// DBに保存
$stmt = $pdo->prepare("INSERT INTO short_urls (original_url, short_code, password_hash, expires_at) VALUES (?, ?, ?, ?)");
$stmt->execute([$originalUrl, $shortCode, $passwordHash, $expiresAtSql]);


$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$shortUrl = "$scheme://$host/tools/url-shortener/php/redirect.php?c=$shortCode";

echo json_encode([
    'success' => true,
    'short_url' => $shortUrl
]);
