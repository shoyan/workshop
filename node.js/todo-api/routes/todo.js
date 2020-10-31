const { Router } = require("express");
const router = Router();
const db = require("../models");
const Todo = db.Todo;

router.get("/todo", (req, res) => {
  Todo.findAll({
    order: [["updatedAt", "DESC"]],
  })
    .then((todo) => {
      res.json(todo);
    })
    .catch((err) => {
      console.error(err);
      res.json(err);
    });
});

router.get("/todo/:id", async (req, res) => {
  const row = await Todo.findOne({
    where: {
      id: req.params.id,
    },
  });

  if (row) {
    res.json(row);
  } else {
    res.sendStatus(404);
  }
});

router.post("/todo", (req, res) => {
  Todo.create({ content: req.body.content })
    .then((todo) => {
      res.status(201).json(todo);
    })
    .catch((err) => {
      console.error(err);
      res.json(err);
    });
});

router.patch("/todo/:id", async (req, res) => {
  const row = await Todo.findOne({
    where: {
      id: req.params.id,
    },
  });

  if (!row) {
    res.sendStatus(404);
  }

  const whiteList = ["content", "done"];
  whiteList.forEach((val) => {
    if (req.body[val] !== undefined) {
      row[val] = req.body[val];
    }
  });

  row
    .save()
    .then(() => {
      res.json(row);
    })
    .catch((err) => {
      console.error(err);
      res.json(err);
    });
});

router.delete("/todo/:id", (req, res) => {
  Todo.destroy({
    where: {
      id: req.params.id,
    },
  })
    .then(() => {
      res.send("");
    })
    .catch((err) => {
      console.error(err);
      res.json(err);
    });
});

module.exports = router;
