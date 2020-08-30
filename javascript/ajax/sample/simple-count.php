<?php
// カウントをインクリメントするスクリプト

session_start();

if (empty($_SESSION['count'])) {
  $_SESSION['count'] = 0;
}
$_SESSION['count']++;

echo json_encode([
  'count' => $_SESSION['count']
]);
