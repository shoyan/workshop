<?php
$fruits = [
  ['name' => 'リンゴ'], 
  ['name' => 'ミカン'],
  ['name' => 'バナナ']
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>sample3.php</title>
</head>
<body>
  <?php foreach($fruits as $fruit): ?>
    <p><?php echo $fruit['name'] ?></p>
  <?php endforeach ?>
</body>
</html>
