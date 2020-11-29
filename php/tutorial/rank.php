<?php
/**
 * ランキングの順位を計算するプログラム
 * 飛び石に対応
 */
$data = [
    ['title' => '記事E', 'likes' => 22],
    ['title' => '記事D', 'likes' => 22],
    ['title' => '記事C', 'likes' => 10],
    ['title' => '記事C', 'likes' => 8],
    ['title' => '記事C', 'likes' => 8],
    ['title' => '記事C', 'likes' => 3],
    ['title' => '記事A', 'likes' => 2],
    ['title' => '記事B', 'likes' => 2],
];

/**
 * ランキングを計算する関数
 */
function addRanking($data) {
    $ranking = 0;
    // １個目のlikesを入れておく
    $likes = $data[0]['likes'];
    // 最初の配列から最後から１個前の配列まで繰り返す
    for ($i = 0; $i < count($data) -1; $i++) {
        // 同一順位の場合に次のランキングを飛ばすための変数
        $rankingOffset = 0;
        // ランキングを加算する
        $ranking+=1;
        // ランキングをセットする
        $data[$i]['ranking'] = $ranking;
        // $iの次の配列から配列の最後まで繰り返す
        for ($j = $i + 1; $j < count($data); $j++) {
            // $iと$jのlikesが同じだったら同一のランキングをつける
            if ($data[$i]['likes'] == $data[$j]['likes']) {
                $data[$j]['ranking'] = $ranking;
                // 同一順位の場合は次のランキングは飛ばしたいので$rankingOffsetを加算する
                $rankingOffset+=1;
            } else {
                // 次のランキングを検査するためにrankingOffsetを$iに加算しておく
                $i = $i + $rankingOffset;
                // ランキングも同じようにrankingOffsetを加算する
                $ranking = $ranking + $rankingOffset;
                // チェックを打ち切る
                break;
            }
        }
    }
    return $data;
}

$rankingData = addRanking($data);
var_dump($rankingData);