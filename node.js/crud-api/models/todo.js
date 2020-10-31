"use strict";
module.exports = (sequelize, DataTypes) => {
  const Todo = sequelize.define(
    "Todo",
    {
      content: DataTypes.STRING,
      done: DataTypes.BOOLEAN,
      createdAt: {
        type: DataTypes.DATE,
        field: "created_at",
      },
      updatedAt: {
        type: DataTypes.DATE,
        field: "updated_at",
      },
    },
    {}
  );
  Todo.associate = function (models) {
    // associations can be defined here
  };
  return Todo;
};
