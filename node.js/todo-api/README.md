# TODO API

TODOリストを操作するAPI

## Build Setup

```bash
# install dependencies
$ npm install

# データベースの作成
$ npx sequelize-cli db:migrate

# serve with hot reload at localhost:3000
$ npm run start
```

## Examples

```bash
# 一覧取得
curl http://localhost:3000/todo/

# TODO作成
curl http://localhost:3000/todo/ -XPOST -d"content=メモです"

# TODO更新
curl http://localhost:3000/api/todo/1 -XPATCH -d "done=true&content=doneを作る"

# TODO削除
curl http://localhost:3000/api/todo/1 -XDELETE
```
