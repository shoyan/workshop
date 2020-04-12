<?php
$uploaded = false;
if (!empty($_FILES['uploaded_file'])) { 
  $upload_dir = './upload_dir/';
  $uploaded_file = $upload_dir . basename($_FILES['uploaded_file']['name']);
  move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $uploaded_file);
  $uploaded = true;
}

$images = glob('./upload_dir/*');

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHPでファイルアップロード</title>
</head>

<body>
  <?php if ($uploaded): ?>
  <p><?php echo "ファイルのアップロードが完了しました。"; ?></p>
  <?php endif ?>

  <form enctype="multipart/form-data" action="index.php" method="POST">
    <input type="hidden" name="name" value="value" />
    アップロード: <input name="uploaded_file" type="file" />
    <input type="submit" value="ファイル送信" />
  </form>

  <?php foreach($images as $image): ?>
    <img src="<?php echo $image; ?> " alt="" srcset="" width="200">
  <?php endforeach ?>
</body>

</html>
