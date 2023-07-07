/**
 * オウム返しをするLINEボット
 */
const functions = require('@google-cloud/functions-framework');
const { Client } = require("@line/bot-sdk");

const lineClient = new Client({
 channelAccessToken: process.env.CHANNEL_ACCESS_TOKEN,
 channelSecret: process.env.CHANNEL_SECRET,
});

functions.http('helloHttp', async (req, res) => {
  const event = req.body.events[0];

  if (event.type === 'message') {
    // メッセージをオウム返しする
    const message = event.message.text;
    const result = await lineClient.replyMessage(event.replyToken, { type: 'text', text: message });
    res.json(result);
  }
});