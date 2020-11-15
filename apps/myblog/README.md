# Myblog

ブログのサンプルアプリ。

## 準備

このチュートリアルではデータベースを利用します。
そのため、データベースの基本的な操作について知っている必要があります。
MacではMAMP、WindowsではXAMPPをインストールすることで環境を用意できます。

### データベースを用意する

まずは、データベースを用意しましょう。
`myblog` という名前でデータベースを作成します。sql文で実行する場合は次のsqlを実行します。

```sql
CREATE DATABASE myblog;
```

### テーブルを用意する

データベースが作成できたら、次はテーブルを作成します。
`myblog.sql` にテーブルを作成するsqlを用意しています。
そのままコピーして実行してもいいですし、次のコマンドでsql文を実行することができます。

```bash
$ mysql -h 127.0.0.1 -u root -P 8889 root myblog < myblog.sql
```

このチュートリアルでは、次の環境下で実行しています。

* ユーザー名: root
* パスワード: root
* ポート番号: 8889

ユーザー名、パスワード、ポート番号はお使いの環境に合わせて変更してください。


テーブルが作成されていることを確認してみましょう。次のようなテーブル情報が表示されていれば成功です！

```bash
$ mysql -h 127.0.0.1 -u root -P 8889 -proot myblog -e "desc posts;"
mysql: [Warning] Using a password on the command line interface can be insecure.
+--------------+---------------+------+-----+-------------------+-----------------------------+
| Field        | Type          | Null | Key | Default           | Extra                       |
+--------------+---------------+------+-----+-------------------+-----------------------------+
| id           | int(11)       | NO   | PRI | NULL              | auto_increment              |
| post_title   | varchar(100)  | NO   |     | NULL              |                             |
| post_content | varchar(5000) | NO   |     | NULL              |                             |
| created_at   | datetime      | NO   |     | CURRENT_TIMESTAMP |                             |
| updated_at   | datetime      | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
+--------------+---------------+------+-----+-------------------+-----------------------------+
```

```text
補足

次の警告文はパスワードがコマンド上に入力されているため表示されています。

mysql: [Warning] Using a password on the command line interface can be insecure.

このチュートリアルではわかりやすさを優先してパスワードをコマンドに含めています。この警告文を出さないようにするためには -p の後のパスワードを消してください。
```

### データベースの接続先の設定

データベースの接続先を設定します。
`database.php` の次の部分をお使いのデータベースの情報に変更してください。

```php
define('DB_HOST', '127.0.0.1'); //データベースのホスト名
define('DB_NAME', 'myblog');  //データベース名
define('DB_USER', 'root');      //データベースのユーザー名
define('DB_PASSWORD', 'root');  //データベースのパスワード
define('DB_PORT', '8889');      //データベースのポート番号
```

## アプリケーションの起動

それでは、アプリケーションを起動しましょう。ここでは、PHPのビルトインサーバーを利用します。
ターミナルで次のコマンドを実行してください。

```bash
# apps/myblogに移動します
$ cd apps/myblog

# ビルトインサーバーを起動します
$ php -S localhost:8000
```

http://localhost:8000 にブラウザでアクセスしてみましょう。
ユーザー登録画面が表示されます。

もし、エラーが表示された場合はデータベースの接続情報を確認してみてください。
