const functions = require('@google-cloud/functions-framework');
const { initializeApp, applicationDefault } = require('firebase-admin/app');
const { getFirestore } = require('firebase-admin/firestore');

initializeApp({
    credential: applicationDefault()
});

const db = getFirestore();

functions.http('helloHttp', async (req, res) => {
    const data = {
        name: 'Los Angeles',
        state: 'CA',
        country: 'USA'
    };
      
    // ドキュメントに書き込み
    const result = await db.collection('cities').doc('LA').set(data);

    // 書き込んだドキュメントを取得
    const cityRef = db.collection('cities').doc('LA');
    const doc = await cityRef.get();
    if (!doc.exists) {
      res.send('No such document!');
    } else {
      res.send(doc.data());
    }
});
