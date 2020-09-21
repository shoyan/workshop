<?php
/**
 * 各画面で利用する関数
 */

/**
 * ユーザー情報を取得
 */
function findUserByEmail($dbh, $email)
{
  $sql = 'SELECT * FROM users WHERE email = ?';
  $stmt = $dbh->prepare($sql);
  $data[] = $email;
  $stmt->execute($data);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * ユーザー情報を認証トークンから取得
 */
function findUserByTempPass($dbh, $tempPass)
{
  $sql = 'SELECT * FROM users WHERE temp_pass = ?';
  $stmt = $dbh->prepare($sql);
  $data[] = $tempPass;
  $stmt->execute($data);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * 認証トークンを更新
 */
function updateUserTempPass($dbh, $userId, $tempPass, $tempPassLimitTime) {
  $sql = 'UPDATE users SET temp_pass = :temp_pass, temp_pass_limit_time = :temp_pass_limit_time WHERE id = :user_id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':temp_pass', $tempPass, PDO::PARAM_STR);
  $stmt->bindValue(':temp_pass_limit_time', $tempPassLimitTime, PDO::PARAM_STR);
  $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
  return $stmt->execute();
}

/**
 * パスワードを更新
 */
function updateUserPassword($dbh, $userId, $password) {
  $sql = 'UPDATE users SET password = :password WHERE id = :user_id';
  $stmt = $dbh->prepare($sql);
  $hashedPassword = getHashedPassword($password);
  $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
  $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
  return $stmt->execute();
}

/**
 * パスワード再発行の認証トークンを取得
 */
function getResetPassword() {
  $length = 32;
  $bytes = random_bytes($length);
  return bin2hex($bytes);
}

/**
 * パスワード再発行のトークンの有効期限を取得
 */
function getTempPassLimitTime() {
  return date("Y-m-d H:i:s", strtotime("+1 hour"));
}

/**
 * 日付をUNIXタイムスタンプに変換
 */
function getUnixTimestamp($date) {
  $date = new DateTime($date);
  return $date->format('U');
}

/**
 * パスワードを暗号化
 */
function getHashedPassword($password) {
  return password_hash($password, PASSWORD_DEFAULT);
}
