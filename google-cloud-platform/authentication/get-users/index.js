const functions = require('@google-cloud/functions-framework');
const { initializeApp, applicationDefault } = require('firebase-admin/app');
const {Storage} = require('@google-cloud/storage');
const admin = require("firebase-admin");
const { getAuth } = require("firebase-admin/auth");
const stringifySync = require("csv-stringify/sync");

initializeApp({
    credential: applicationDefault()
});

let nextPageToken = '';
const UserList = [];

console.log("start")

const listAllUsers = (nextPageToken) => {
    // List batch of users, 1000 at a time.
    // console.log('nextPageToken' + nextPageToken);
    getAuth()
      .listUsers(1, nextPageToken)
      .then((listUsersResult) => {
        listUsersResult.users.forEach((userRecord) => {
          UserList.push(userRecord)
          // console.log('user', userRecord.toJSON());
        });
        if (listUsersResult.pageToken) {
          // List next batch of users.
          listAllUsers(listUsersResult.pageToken);
        } else {
          // create CSV file.
          console.log(UserList)
        }
      })
      .catch((error) => {
        console.log('Error listing users:', error);
      });
  };

functions.http('helloHttp', async (req, res) => {
    listAllUsers().then(async (userList) => {
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
});