<?php
if (!empty($_POST)) {
  $data = <<<EOD
    タイトル: {$_POST['title']}
    内容: {$_POST['memo']} 
  EOD;
  
  file_put_contents("memo.txt", $data);
}

$contents = file_get_contents("memo.txt");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="index.php" method="post">
    <div>
    タイトル: <input type="text" name="title">
    </div>
    <div>
    内容: <input type="text" name="memo">
    </div>
    <button type="submit">送信</button>
  </form>
  <p><?php echo $contents ?></p>
</body>
</html>
