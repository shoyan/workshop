<?php
$pref_list = [
    ['id' => 'Hokkaido', 'name' => '北海道'],
    ['id' => 'Aomori', 'name' => '青森県'],
    ['id' => 'Iwate', 'name' => '岩手県'],
    ['id' => 'Miyagi', 'name' => '宮城県'],
    ['id' => 'Akita', 'name' => '秋田県'],
    ['id' => 'Yamagata', 'name' => '山形県'],
    ['id' => 'Fukushima', 'name' => '福島県'],
    ['id' => 'Ibaragi', 'name' => '茨城県'],
    ['id' => 'Tochigi', 'name' => '栃木県'],
    ['id' => 'Gunma', 'name' => '群馬県'],
    ['id' => 'Saitama', 'name' => '埼玉県'],
    ['id' => 'Chiba', 'name' => '千葉県'],
    ['id' => 'Tokyo', 'name' => '東京都'],
    ['id' => 'Kanagawa', 'name' => '神奈川県'],
    ['id' => 'Niigata', 'name' => '新潟県'],
    ['id' => 'Toyama', 'name' => '富山県'],
    ['id' => 'Ishikawa', 'name' => '石川県'],
    ['id' => 'Fukui', 'name' => '福井県'],
    ['id' => 'Yamanashi', 'name' => '山梨県'],
    ['id' => 'Nagano', 'name' => '長野県'],
    ['id' => 'Gifu', 'name' => '岐阜県'],
    ['id' => 'Shizuoka', 'name' => '静岡県'],
    ['id' => 'Aichi', 'name' => '愛知県'],
    ['id' => 'Mie', 'name' => '三重県'],
    ['id' => 'Shiga', 'name' => '滋賀県'],
    ['id' => 'Kyoto', 'name' => '京都府'],
    ['id' => 'Osaka', 'name' => '大阪府'],
    ['id' => 'Hyogo', 'name' => '兵庫県'],
    ['id' => 'Nara', 'name' => '奈良県'],
    ['id' => 'Wakayama', 'name' => '和歌山県'],
    ['id' => 'Tottori', 'name' => '鳥取県'],
    ['id' => 'Shimane', 'name' => '島根県'],
    ['id' => 'Okayama', 'name' => '岡山県'],
    ['id' => 'Hiroshima', 'name' => '広島県'],
    ['id' => 'Yamaguchi', 'name' => '山口県'],
    ['id' => 'Tokushima', 'name' => '徳島県'],
    ['id' => 'Kagawa', 'name' => '香川県'],
    ['id' => 'Ehime', 'name' => '愛媛県'],
    ['id' => 'Kochi', 'name' => '高知県'],
    ['id' => 'Fukuoka', 'name' => '福岡県'],
    ['id' => 'Saga', 'name' => '佐賀県'],
    ['id' => 'Nagasaki', 'name' => '長崎県'],
    ['id' => 'Kumamoto', 'name' => '熊本県'],
    ['id' => 'Oita', 'name' => '大分県'],
    ['id' => 'Miyazaki', 'name' => '宮崎県'],
    ['id' => 'Kagoshima', 'name' => '鹿児島県'],
    ['id' => 'Okinawa', 'name' => '沖縄県'],
    ['id' => 'Other', 'name' => 'その他']
];

if (isset($_POST['pref'])) {
    $selected_id = $_POST['pref'];
} else {
    $selected_id = null;
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="w'id'th=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>

<body>
    <form action="pref.php" method="post">
        <div class="form_item">
            <label>Prefecture
                <select name="pref">
                    <?php foreach ($pref_list as $pref) : ?>
                        <option value="<?php echo $pref['id'] ?>" <?php echo $selected_id == $pref['id']? 'selected' : '' ?>><?php echo $pref['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </label>
            <input class="btn bg_green" type="submit" value="Confirm">
        </div>
    </form>
    　
</body>

</html>