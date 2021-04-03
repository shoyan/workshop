# Validation form
フォームとバリデーション処理を学習します。

## 事前準備
### MAMPのインストール
MAMPをインストールして起動しておいてください。

### ソースコードの設置
`validation-form/`のフォルダをMAMPの`htdocs/`ディレクトリに置きます。

`htdocs/`フォルダの場所は次の通りです。OSによって異なるので注意してください。
- Mac: `/Applications/MAMP/htdocs/`
- Windows: `C:\MAMP\htdocs\`

## 動作確認

## Step1

次のURLにアクセスします。
`http://localhost/validation-form/step1/index.php`

バリデーションを実装したフォームです。
入力しない場合はエラーメッセージが表示されます。

## Step2

次のURLにアクセスします。
`http://localhost/validation-form/step2/index.php`

Step1は入力値が保持されませんでした。step2は入力値を保持するように改良したフォームです。

## Step3
step3は入力値をデータベースに登録します。

データベースの準備を行います。
`step3/ddl.sql`をデータベースにインポートしてください。

次のURLにアクセスします。
`http://localhost/validation-form/step3/index.php`


## 補足情報

step1、step2、step3は同じCSS(style.css)を利用しています。
