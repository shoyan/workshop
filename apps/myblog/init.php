<?php
/**
 * アプリの初期処理
 */

// PHPのエラーを表示するように設定
ini_set('display_errors', "1");
// E_NOTICE を表示させるのもおすすめ（初期化されていない変数、変数名のスペルミスなど…）
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

require_once('./database.php');
require_once('./functions.php');