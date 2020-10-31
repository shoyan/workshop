const express = require("express");
const app = express();
const port = 3000
const bodyParser = require("body-parser");

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

// Import API Routes
app.use(require("./routes/todo"));

app.listen(port, () => {
  console.log(`Example app listening at http://localhost:${port}`);
});
