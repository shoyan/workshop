const functions = require('@google-cloud/functions-framework');
const { initializeApp, applicationDefault } = require('firebase-admin/app');
const {Storage} = require('@google-cloud/storage');

initializeApp({
    credential: applicationDefault()
});
const bucketName = 'gcp-sample-5fbb7';
const storage = new Storage();
 
functions.http('helloHttp', async (req, res) => {
    const myBucket = storage.bucket('gcp-sample-5fbb7');
    const file = myBucket.file('my-file');
    const contents = 'This is the contents of the file.';
    await file.save(contents);
    res.send('completed');
});