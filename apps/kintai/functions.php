<?php
/**
 * 関数
 */

 /**
  * HTMLエスケープ関数
  */
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

/**
 * 勤怠レコードを登録する
 * @param $record_type レコード種別
 * @param $record_time 登録する時間
 */
function createAttendanceRecord($recordType, $recordTime) {
    global $dbh;
    $stmt = $dbh->prepare("INSERT INTO attendance_records(record_type, record_time) VALUES (?, ?)");
    $stmt->bindParam(1, $recordType, PDO::PARAM_STR);
    $stmt->bindParam(2, $recordTime, PDO::PARAM_STR);
    return $stmt->execute();
}

/**
 * 勤怠レコードを全件数取得する
 * @return array 勤怠レコード
 */
function getAllAttendanceRecord($target_date) {
    global $dbh;
    $stmt = $dbh->prepare("SELECT * FROM attendance_records WHERE record_time BETWEEN ? AND ?");
    $start = $target_date . "-01 00:00:00";
    $end   = $target_date . "-31 23:59:59";
    $stmt->bindParam(1, $start);
    $stmt->bindParam(2, $end);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * 勤怠種別を日本語に変換する
 * @param $record_type 勤怠種別
 * @return string 勤怠種別
 */
function getRecordType($record_type) {
    $master = [
        'Commuting' => '出勤',
        'LeaveWork' => '退勤'
    ];
    return $master[$record_type];
}
