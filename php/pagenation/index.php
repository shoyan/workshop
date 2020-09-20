<?php
/**
 * 1つ前のデータを取得する
 * @param $id 現在のデータのid
 */
function getPrevData($id) {
  // idの最小値
  $minId = 1;

  // idが最小値よりも大きい場合は前のデータを作成　
  if ($id > 1) {
    $id -= 1;
    $data = [
      'title' => '前へ',
      'url' => "http://localhost:8080/?id=${id}"
    ];
    return $data;
  }
  return [];
}

/**
 * 次のデータを取得する
 * @param $id 現在のデータのid
 */
function getNextData($id) {
  // idの最大値
  $maxId = 10;

  // idが最大値よりも小さい場合は次のデータを作成　
  if ($id < $maxId) {
    $id += 1;
    $data = [
      'title' => '次へ',
      'url' => "http://localhost:8080/?id=${id}"
    ];
    return $data;
  }
  return [];
}

// 数値に変換する
$id = intval($_GET['id']);
$maxId = 10;
// idのチェック
// 数値で0以上maxID以下であることをチェックする。
// 条件を満たさない場合はid=1にリダイレクトする。
if (empty($id) || $id <= 0 || $id > $maxId) {
  header('location: /?id=1');
  exit;
}

$prev = getPrevData($id);
$next = getNextData($id);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ページネーションのサンプル</title>
</head>
<body>

<?php if (!empty($prev)): ?>
  <a href="<?php echo $prev['url']?>"><?php echo $prev['title']?></a>
<?php else: ?>
前へ
<?php endif ?>

<?php if (!empty($next)): ?>
  <a href="<?php echo $next['url']?>"><?php echo $next['title']?></a>
<?php else: ?>
次へ
<?php endif ?>

</body>
</html>
