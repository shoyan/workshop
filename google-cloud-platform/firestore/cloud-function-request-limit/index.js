/**
 * リクエスト数の制限を行う
 * 
 * リクエストの履歴をfirestoreに登録
 * リクエスト数が1日3件以上の場合、制限をかける
 */
const functions = require('@google-cloud/functions-framework');
const { initializeApp, applicationDefault } = require('firebase-admin/app');
const { getFirestore, FieldValue } = require('firebase-admin/firestore');

// now（Date型）の0時0分0秒のUNIXタイムスタンプを取得する (秒単位）
const getTimestamp = (now) => {
    const today = new Date( now.getFullYear(), now.getMonth(), now.getDate(), 0, 0, 0 ) ;
    return Math.floor( today.getTime() / 1000 )
}

initializeApp({
    credential: applicationDefault()
});

const db = getFirestore();

functions.http('helloHttp', async (req, res) => {
    const userId = req.query.userId;
    if (!userId) {
        res.send('userId not found.');
        return;
    }

    // 書き込んだドキュメントを取得
    const logsRef = db.collection('requests').doc(userId).collection('logs');
    // 最新の3件を取得
    const snapshot = await logsRef.orderBy('requestDate', 'desc').limit(3).get();
    // 今日以降のリクエストのみフィルタリングする
    const now = new Date() ;
    const result = snapshot.docs.filter(doc => doc.data().requestDate.seconds > getTimestamp(now))
    console.log(result.length)

    if (result.length >= 3) {
        res.send('リクエスト数の上限です。')
        return;
    } 

    // リクエストのログを記録
    const data = {
        requestDate: FieldValue.serverTimestamp(),
    };
    await db.collection('requests').doc(userId).collection('logs').add(data)

    res.send('リクエストが完了しました。')
});