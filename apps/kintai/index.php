<?php
// アプリの初期処理
require_once('init.php');

// 出勤時間の登録
if (isset($_REQUEST['commuting'])) {
    $record_type= 'Commuting';
    $record_time = date("Y-m-d H:i:s");
    createAttendanceRecord($record_type, $record_time);
}

// 退勤時間の登録
if (isset($_REQUEST['leaveWork'])) {
    $record_type = 'LeaveWork';
    $record_time = date("Y-m-d H:i:s");
    createAttendanceRecord($record_type, $record_time);
}

// 勤怠データを登録する変数を定義
$attendance_records = [];

// 対象年月の取得
if (isset($_REQUEST['date'])) {
    $current_date = $_REQUEST['date'];
} else {
    $current_date = date('Y-m');
}

// 勤怠データを取得
$all_record = getAllAttendanceRecord($current_date);

// その月の日付を作成
// 月の日数を取得
$day_count = date('t', strtotime($current_date));
// 1日〜月末のデータを作成する
for($i = 1; $i <= $day_count; $i++) {
    $key = $current_date . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
    $attendance_records[$key] = [
        'Commuting' => '',
        'LeaveWork' => '',
    ];
}

// 最も新しい出勤、退勤時間で表示データを作成する
foreach($all_record as $record) {
    $key = date("Y-m-d" , strtotime($record['record_time']));
    if ($record['record_type'] === 'Commuting') {
        $attendance_records[$key]['Commuting'] = date("H:i:s" , strtotime($record['record_time']));
    }
    if ($record['record_type'] === 'LeaveWork') {
        $attendance_records[$key]['LeaveWork'] = date("H:i:s" , strtotime($record['record_time']));
    }
}
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
  <ul>
      <li><a href="./index.php?date=2021-05">2021年5月</a></li>
      <li><a href="./index.php?date=2021-06">2021年6月</a></li>
  </ul>
  <form action="" method="post">
    <button type="submit" name="commuting">出勤</button>
    <button type="submit" name="leaveWork">退勤</button>
  </form>

  <ul>
  <table border="1">
    <thead>
        <tr>
            <th>日付</th>
            <th>出勤時間</th>
            <th>退勤時間</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($attendance_records as $date => $record): ?>
          <tr>
            <td><?php echo $date ?></td>
            <td><?php echo $record['Commuting'] ?></td>
            <td><?php echo $record['LeaveWork'] ?></td>
          </tr>
        <?php endforeach ?>
    </tbody>
  </table>
  </ul>
</div>
</body>
</html>