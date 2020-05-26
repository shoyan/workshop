<?php
session_start();
if (empty($_SESSION['count'])) {
  $_SESSION['count'] = 0;
}
$_SESSION['count']++;

echo json_encode([
  // 'fav_id' => $_POST['fav_id'],
  'fav_count' => $_SESSION['count']]
);
