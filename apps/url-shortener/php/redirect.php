<?php
// redirect.php

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
    echo "DB接続エラー";
    exit;
}

// URLパラメータからコード取得
$shortCode = $_GET['c'] ?? '';
if (empty($shortCode)) {
    http_response_code(400);
    echo "URLが無効です";
    exit;
}

// データ取得
$stmt = $pdo->prepare("SELECT * FROM short_urls WHERE short_code = ?");
$stmt->execute([$shortCode]);
$data = $stmt->fetch();

if (!$data) {
    http_response_code(404);
    echo "リンクが見つかりません";
    exit;
}

// 有効期限チェック
if (!empty($data['expires_at']) && strtotime($data['expires_at']) < time()) {
    echo "このリンクの有効期限は切れています";
    exit;
}

// パスワードチェックが必要か
$requiresPassword = !empty($data['password_hash']);
$enteredPassword = $_POST['password'] ?? null;

if ($requiresPassword && ($_SERVER['REQUEST_METHOD'] !== 'POST' || !password_verify($enteredPassword, $data['password_hash']))) {
    // パスワードが間違っていた場合、エラーメッセージを表示
    echo '<!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>パスワード認証</title>
    </head>
    <body>
        <h2>このリンクはパスワードで保護されています</h2>';

    // パスワードが間違った場合のエラーメッセージ
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<p style="color: red;">パスワードが間違っています。再度入力してください。</p>';
    }

    echo '
        <form method="POST">
            <input type="password" name="password" placeholder="パスワードを入力" required>
            <button type="submit">送信</button>
        </form>
    </body>
    </html>';
    exit;
}

// アクセスログ保存
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$stmt = $pdo->prepare("INSERT INTO access_logs (short_code, ip_address) VALUES (?, ?)");
$stmt->execute([$shortCode, $ip]);

// リダイレクト！
header("Location: " . $data['original_url']);
exit;
