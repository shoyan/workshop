/**
 * リクエストログをFirestoreに保存するサンプルコード
 */
const functions = require('@google-cloud/functions-framework');
const { Client, validateSignature, SignatureValidationFailed } = require("@line/bot-sdk");
const { initializeApp, applicationDefault } = require('firebase-admin/app');
const { getFirestore, FieldValue } = require('firebase-admin/firestore');

initializeApp({
  credential: applicationDefault()
});

const db = getFirestore();

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
    const result = await lineClient.replyMessage(event.replyToken, { type: 'text', text: message });

    // リクエストのログを記録
    const data = {
        requestDate: FieldValue.serverTimestamp(),
    };
    await db.collection('requests').doc(userId).collection('logs').add(data)

    res.json(result);
  }
});