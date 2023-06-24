# Cloud-function-firebase-tutorial

## 0から環境構築
以下のコマンドで作成します。

```
$ mkdir cloud-function-firebase-tutorial
$ cd cloud-function-firebase-tutorial
$ npm init -y
$ npm install @google-cloud/functions-framework
$ npm install firebase-admin
```

## エミュレーターを利用する
```
$ gcloud emulators firestore start --host-port=\[::1\]:8405
$ export FIRESTORE_EMULATOR_HOST=[::1]:8405
```