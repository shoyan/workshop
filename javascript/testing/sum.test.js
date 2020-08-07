const sum = require("./sum");

test("adds 1 + 2 to equal 3", () => {
  // expect(sum(1, 2)).toEqual("3");
  expect(sum(1, 2)).toBe(3);
  expect(sum(-1, -2)).toBe(-3);
  expect(sum(0, 0)).toBe(0);
  expect(sum(null, null)).toBe(0);
});

test("オブジェクトのアサインテスト", () => {
  const data = { one: 1 };
  data["two"] = 2;
  expect(data).toEqual({ one: 1, two: 2 });
});

test("null", () => {
  const n = null;
  expect(n).toBeNull();
  expect(n).toBeDefined();
  expect(n).not.toBeUndefined();
  expect(n).not.toBeTruthy();
  expect(n).toBeFalsy();
});

test("zero", () => {
  const z = 0;
  expect(z).not.toBeNull();
  expect(z).toBeDefined();
  expect(z).not.toBeUndefined();
  expect(z).not.toBeTruthy();
  expect(z).toBeFalsy();
});
