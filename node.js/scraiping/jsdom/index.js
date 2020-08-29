const https = require("https");
const { JSDOM } = require("jsdom");

https
  .get("https://news.yahoo.co.jp/", (res) => {
    // レスポンスをいれる配列
    const responses = []

    res.on("data", (d) => {
      responses.push(d)
    });

    // レスポンスを全て取得したらendが実行される
    res.on("end", () => {
      const html = responses.map((d) => d.toString()).join('')
      const dom = new JSDOM(html);
      const h1 = dom.window.document.querySelector("h1");
      console.log(h1.textContent);
      const lis = dom.window.document.querySelectorAll(".topics_content li.topicsListItem");
      lis.forEach((li) => {
        console.log(li.textContent)
      })
    });
  })
  .on("error", (e) => {
    console.error(e);
  });
