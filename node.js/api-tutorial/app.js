const express = require("express");
const app = express();
const port = 3000;

app.get("/", (req, res) => {
  res.send("Hello World!");
});

app.get("/users", (req, res) => {
  res.json({
    userName: "yamasaki",
    address: "福岡県"
  });
});

app.post("/users", (req, res) => {
  res.json({
    userName: "yamasaki",
    address: "福岡県"
  });
});

app.listen(port, () => {
  console.log(`Example app listening at http://localhost:${port}`);
});
