// const promise1 = new Promise((resolve, reject) => {
//     setTimeout(() => {
//       resolve('foo');
//     }, 300);
//   });
  
//   promise1.then((value) => {
//     console.log(value);
//     // Expected output: "foo"
//   });
  
//   console.log(promise1);
//   // Expected output: [object Promise]

const promise1 = new Promise((resolve, reject) => {
    setTimeout(() => {
        reject('error');
    }, 300)
})

const myAsyncFunction = (url) => {
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest()
      xhr.open("GET", url)
      xhr.onload = () => resolve(xhr.responseText)
      xhr.onerror = () => reject(xhr.statusText)
      xhr.send()
    });
  }

promise1.then(value => {
    console.log(value);
}).catch(err => {
    console.log('catch', err);
})

myAsyncFunction('https://jsonplaceholder.typicode.com/todos/1').then(response => {
    console.log(response)
});