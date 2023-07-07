/**
 * 1日3回までの利用制限を行うLINEボットのサンプル
 */
const functions = require('@google-cloud/functions-framework');
const { Client, validateSignature, SignatureValidationFailed } = require("@line/bot-sdk");
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

// 課金ユーザーの場合はtrue
// そうでない場合はfalseを返す
const getPaidStatus = async (userId) => {
  const userRef = db.collection('users').doc(userId);
  const doc = await userRef.get();
  if (!doc.exists) {
    return false;
  } else {
      if (doc.data().paid) {
        return true;
      } else {
        return false;
      }
  }
}


const lineClient = new Client({
 channelAccessToken: process.env.CHANNEL_ACCESS_TOKEN,
 channelSecret: process.env.CHANNEL_SECRET,
});

functions.http('helloHttp', async (req, res) => {

  // 署名の検証
  const channelSecret = process.env.CHANNEL_SECRET;
  const signature = req.header("x-line-signature") ?? "";
  if (!validateSignature(req.rawBody, channelSecret, signature)) {
    throw new SignatureValidationFailed("invalid signature");
  }

  const event = req.body.events[0];
  const userId = event.source.userId;

  if (event.type === 'message') {

    const message = event.message.text;

    // 書き込んだドキュメントを取得
    const logsRef = db.collection('requests').doc(userId).collection('logs');
    // 最新の3件を取得
    const snapshot = await logsRef.orderBy('requestDate', 'desc').limit(3).get();
    // 今日以降のリクエストのみフィルタリングする
    const now = new Date() ;
    const count = snapshot.docs.filter(doc => doc.data().requestDate.seconds > getTimestamp(now)).length

    // 課金ユーザーチェック
    const paidStatus = await getPaidStatus(userId);
    // 課金ユーザーではない かつ 1日の利用回数が3件以上の場合は制限をかける
    if (!paidStatus && count >= 3) {
        const result = await lineClient.replyMessage(event.replyToken, { type: 'text', text: 'ごめんなさい。また明日連絡してくださいね。' });
        res.json(result);
        return;
    } 

    // 返信
    const result = await lineClient.replyMessage(event.replyToken, { type: 'text', text: message });

    // リクエストのログを記録
    const data = {
        requestDate: FieldValue.serverTimestamp(),
    };
    await db.collection('requests').doc(userId).collection('logs').add(data)

    res.json(result);
  }
});