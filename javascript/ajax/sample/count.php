<?php
session_start();

$postId = $_POST['post_id'];

if (empty($_SESSION['count'][$postId])) {
  $_SESSION['count'] = array_merge($_SESSION['count'], [$postId => 0]);
}
$_SESSION['count'][$postId]++;

echo json_encode([
  'post_id' => $_POST['post_id'], 
  'fav_count' => $_SESSION['count'][$postId]
]);
