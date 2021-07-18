<?php
/**
 * 画像かどうかをチェックする
 */
function is_image_file($file_path) {
  // 定数については以下のURLを参照してください。
  // https://www.php.net/manual/ja/function.exif-imagetype.php
  $allow_image_type = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];

  if (empty($file_path)) {
    return false;
  }

  //画像ファイルかのチェック
  $result = exif_imagetype($file_path); 
  if (in_array($result, $allow_image_type)) {
    return true;
  } else {
    return false;
  }
}

$uploaded = false;
if (!empty($_FILES['uploaded_file'])) { 
  $upload_dir = './upload_dir/';
  $uploaded_file = $upload_dir . basename($_FILES['uploaded_file']['name']);

  //画像ファイルかのチェック
  if (is_image_file($_FILES['uploaded_file']['tmp_name'])) {
    move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $uploaded_file);
    $message = '画像をアップロードしました';
  } else {
    $message = '画像ファイルではありません';
  }

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
  <style>
    #image-upload-form {
      display: inline-block;
      border: 1px solid gray;
      padding: 20px;
      margin: 20px 0;
    }
    #image-upload-form .upload-btn {
      display: block;
      margin-top: 20px;
      background-color: #4169e1;
      color: white;
      border: 0;
      padding: 10px;
      cursor: pointer;
    }

  </style>
</head>

<body>
  <?php if ($uploaded): ?>
    <p><?php echo $message; ?></p>
  <?php endif ?>

  <form id="image-upload-form" enctype="multipart/form-data" action="index.php" method="POST">
    <input type="hidden" name="name" value="value" />
    アップロード: <input name="uploaded_file" type="file" />
    <input class="upload-btn" type="submit" value="ファイルをアップロード" />
  </form>

  <div>
    <?php foreach($images as $image): ?>
      <img src="<?php echo $image; ?> " alt="" srcset="" width="200">
    <?php endforeach ?>
  </div>
</body>

</html>
