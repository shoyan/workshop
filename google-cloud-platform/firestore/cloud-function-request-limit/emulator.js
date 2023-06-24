const functions = require('@google-cloud/functions-framework');
const { initializeApp, applicationDefault } = require('firebase-admin/app');
const { getFirestore, FieldValue } = require('firebase-admin/firestore');

initializeApp({
    credential: applicationDefault()
});

const db = getFirestore();

// now（Date型）の0時0分0秒のUNIXタイムスタンプを取得する (秒単位）
const getTimestamp = (now) => {
    const today = new Date( now.getFullYear(), now.getMonth(), now.getDate(), 0, 0, 0 ) ;
    return Math.floor( today.getTime() / 1000 )
}

(async () => {
    const userId = "11111";

    // 書き込んだドキュメントを取得
    const logsRef = db.collection('requests').doc(userId).collection('logs');
    // 最新の3件を取得
    const snapshot = await logsRef.orderBy('requestDate', 'desc').limit(3).get();
    // 今日以降のリクエストのみフィルタリングする
    const now = new Date() ;
    const result = snapshot.docs.filter(doc => doc.data().requestDate.seconds > getTimestamp(now))
    console.log(result.length)

    if (result.length >= 3) {
        console.log('リクエスト数の上限です。')
        return;
    } 

    console.log('リクエストが完了しました。')

    // リクエストのログを記録
    const data = {
        requestDate: FieldValue.serverTimestamp(),
    };
    await db.collection('requests').doc(userId).collection('logs').add(data)
})();