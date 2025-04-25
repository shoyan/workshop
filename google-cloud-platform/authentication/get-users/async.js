
const listAllUsers = () => {
    const list = [];
    return new Promise((resolveP, rejectP) => {
        const getList = (nextPageToken) => {
          return new Promise((resolve, reject) => {
            setTimeout(() => {
              list.push(nextPageToken);
              nextPageToken--;
              resolve(nextPageToken);
            }, 300)
          }).then(val => {
            if (val > 0) {
              getList(nextPageToken)
            } else {
              resolveP(list)
            }
          });
        }
        getList(10);
    })
};  

  listAllUsers().then((value) => {
    console.log('完了', value);
  });
  