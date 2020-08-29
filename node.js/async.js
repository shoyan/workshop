const fs = require('fs')
const util = require('util')

// 非同期メソッド
fs.readFile(`${__dirname}/hello.txt`, 'utf8', (err, data) => {
  if (err) throw err
  // console.log(data);
});

// 非同期メソッドの戻り値をPromiseにする
const readFileAsync = util.promisify(fs.readFile)
// readFileAsync(`${__dirname}/hello.txt`, 'utf8').then((data) => {
//   console.log(data)
// })

async function main() {
  const data = await readFileAsync(`${__dirname}/hello.txt`, 'utf8')
  console.log(data)
  console.log("done!")
}
main()

// (async () => {
//   const data = await readFileAsync(`${__dirname}/hello.txt`, "utf8");
//   console.log(data);
//   console.log("done!");
// })();

// 同期メソッド
// const data = fs.readFileSync(`${__dirname}/hello.txt`, 'utf8')
// console.log(data)
