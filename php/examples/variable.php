<?php
// 代入
$age = $_GET['age'];

if ($age >= 20) {
    $message = "あなたは" . $age . "歳です。投票権があります";
} else {
    $message = "あなたは" . $age . "歳です。投票権がありません";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <form action="variable.php">
       <input type="text" name="age">
       <button type="submit">送信</button>
   </form> 
   <p><?php echo $message; ?></p>
</body>
</html>