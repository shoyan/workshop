<?php

function view() {
  echo "viewを実行\n";
}

class Model {
  public static function where($type, $value)
  {
    // idを元にユーザーデータを取得

    // ユーザーオブジェクトを作成
    $model = new static("猪木");
    return $model;
  }
}

class User2 extends Model {
  // プロパティ：名前
  public $name;

  // newした時にコンストラクタが実行される
  function __construct($name)
  {
    print "コンストラクタを実行\n";
    $this->name = $name;
    $this->validate();
    view();
  }

  public function validate() {
    echo "validateを実行\n";
    return true;
  }

  // メソッド：名前を取得する
  public function getName() {
    return $this->name;
  }

  // メソッド：ユーザーを登録する
  public function create() {
    // ユーザー登録処理
    return "ユーザーを登録しました";
  }
}

// クラスをnewしたものがオブジェクト
// $user = new User("山崎");
// echo "名前(プロパティでアクセス)： " . $user->name;
// echo "\n";
// echo "名前(メソッドでアクセス)： " . $user->getName();
// echo "\n";

// $id = 1;
// 1行で書いた場合
// echo User::where('id', $id)->getName();

// 2行で書いた場合
// $result = $user->create();
// echo $result;

// 1行で書いた場合
// echo $user->create();

$user1 = new User("山崎");
$user2 = new User("猪木");
$user3 = new User("太郎");

$data = [
  "user1" => $user1,
  "user2" => $user2,
  "user3" => $user3
];
echo $data["user1"]->getName();

echo "\n";

$list = [$user1, $user2, $user3];
echo $list[0]->getName();

// foreach($list as $value) {
//   echo $value->getName() . "\n";
// }
