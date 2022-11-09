<?php
// メッセージが空の場合は入力を促すメッセージをセットする
if (empty($_GET['message'])) {
    $org_message = '';
    $message = '何か入力してニャ！';
} else {
    $org_message = $_GET['message'];
    $message = $_GET['message'] . 'ニャー！';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #output {
            color: red;
            font-size: 32px;
        }
    </style>
</head>
<body>
    <h1>猫語コンバーター</h1>
    <p>入力した文字を猫語に変換します。</p>

    <form action="./cat.php" method="get">
        <input type="text" name="message" value="<?php echo $org_message ?>">
        <button>実行</button>
    </form>

    <p id="output"><?php echo $message ?></p>

</body>
</html>