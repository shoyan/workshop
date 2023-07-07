/**
 * オウム返しをするLINEボット（検証機能付き）
 */
const functions = require('@google-cloud/functions-framework');
const { Client, validateSignature, SignatureValidationFailed } = require("@line/bot-sdk");

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

  if (event.type === 'message') {
    // メッセージをオウム返しする
    const message = event.message.text;
    const result = await lineClient.replyMessage(event.replyToken, { type: 'text', text: message });
    res.json(result);
  }
});