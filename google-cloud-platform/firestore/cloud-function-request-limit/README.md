# Cloud-function-request-limit

リクエスト数の制限を行うサンプルコードです。

## エミュレーターを起動
以下のコマンドでエミュレーターを起動して開発を行うことができます。
```
$ gcloud emulators firestore start
```

以下のコマンドで環境変数に設定することで自動的にエミュレーターに接続されます。

```
export FIRESTORE_EMULATOR_HOST=[::1]:8278
```

- [アプリを Cloud Firestore エミュレータに接続する | Firebase Local Emulator Suite](https://firebase.google.com/docs/emulator-suite/connect_firestore?hl=ja#node.js-admin-sdk)