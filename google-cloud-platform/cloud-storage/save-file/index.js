const functions = require('@google-cloud/functions-framework');
const { initializeApp, applicationDefault } = require('firebase-admin/app');
const {Storage} = require('@google-cloud/storage');
const stringifySync = require("csv-stringify/sync");

initializeApp({
    credential: applicationDefault()
});
const bucketName = 'gcp-sample-5fbb7';
const storage = new Storage();

async function listFiles() {
    // Lists files in the bucket
    const [files] = await storage.bucket(bucketName).getFiles();
    console.log('Files:');
    return files
}
 
functions.http('helloHttp', async (req, res) => {
    const myBucket = storage.bucket(bucketName);
    const data = [
        { Email: 'info1@example.com', FirstName: '山田', LastName: '太郎' },
        { Email: 'info2@example.com', FirstName: '山田', LastName: '次郎' },
        { Email: 'info3@example.com', FirstName: '山田', LastName: '三郎' },
    ];
    const content = stringifySync.stringify(
        data
      , {
        header: true,
        columns: [
            { key: 'Email', header: 'Email Address'},
            { key: 'FirstName', header: 'First Name'},
            { key: 'LastName', header: 'Last Name' }
        ]
    });
    const file = myBucket.file('my-file02.csv');
    await file.save(content);
    res.send('completed')
});