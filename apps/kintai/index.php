<?php
// アプリの初期処理
require_once('init.php');

if (isset($_REQUEST['commuting'])) {
    $record_type= 'Commuting';
    $record_time = date("Y-m-d H:i:s");
    createAttendanceRecord($record_type, $record_time);
}

if (isset($_REQUEST['leaveWork'])) {
    $record_type = 'LeaveWork';
    $record_time = date("Y-m-d H:i:s");
    createAttendanceRecord($record_type, $record_time);
}

$attendance_records = getAllAttendanceRecord();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id ="content">
  <h1>勤怠管理</h1>
  <form action="" method="post">
    <button type="submit" name="commuting">出勤</button>
    <button type="submit" name="leaveWork">退勤</button>
  </form>

  <ul>
  <table border="1">
    <thead>
        <tr>
            <th>時間</th>
            <th>区分</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($attendance_records as $record): ?>
          <tr>
            <td><?php echo $record['record_time']?></td>
            <td><?php echo getRecordType($record['record_type']) ?></td>
          </tr>
        <?php endforeach ?>
    </tbody>
  </table>
  </ul>
</div>
</body>
</html>