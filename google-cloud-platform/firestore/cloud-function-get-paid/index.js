const functions = require('@google-cloud/functions-framework');
const { initializeApp, applicationDefault } = require('firebase-admin/app');
const { getFirestore } = require('firebase-admin/firestore');

initializeApp({
    credential: applicationDefault()
});

const db = getFirestore();

functions.http('getPaid', async (req, res) => {
    const userRef = db.collection('users').doc(req.query.userId);
    const doc = await userRef.get();
    if (!doc.exists) {
      res.send('not found');
    } else {
        if (doc.data().paid) {
          res.send('あなたは課金ユーザーです');
        } else {
          res.send('あなたは無料ユーザーです');
        }
    }
});
