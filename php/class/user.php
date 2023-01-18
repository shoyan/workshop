<?php
// ユーザークラス
class User {
    // 性別
    public $gender;
    // 国籍
    public $country;
    // 年齢
    public $age;
    // 名前
    public $user_name;

    // コンストラクタを定義する
    public function __construct(string $name, int $age, string $gender, string $country) {
        $this->user_name = $name;
        $this->age = $age;
        $this->gender = $gender;
        $this->country = $country;
    }

    // 名前を設定する
    public function set_name(string $name) {
        $this->user_name = $name;
    }
    // 性別を設定する
    public function set_gender(string $gender) {
        $this->gender = $gender;
    }
    // 国籍を設定する
    public function set_country(string $country) {
        $this->country = $country;
    }
    // 年齢を設定する
    public function set_age(int $age) {
        $this->age = $age;
    }
}

$yamasaki = new User('山田', 37, '男', '日本');
