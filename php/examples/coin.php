<?php
    $response = file_get_contents('https://api.coingecko.com/api/v3/coins/list');
    $coinList = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Coin List</h1>
    <ul id="list">
        <?php foreach($coinList as $data): ?>
            <li><?php echo $data['id'] ?></li>
        <?php endforeach ?>
    </ul>
</body>
</html>