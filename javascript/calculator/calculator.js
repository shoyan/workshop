const display = document.querySelector("#display");
const btn1 = document.querySelector("#btn1");
const btn2 = document.querySelector("#btn2");
const btn3 = document.querySelector("#btn3");
const clear = document.querySelector("#clear");
const btnAdd = document.querySelector("#btn-add");
const btnEqual = document.querySelector("#btn-equal");
const btnMulti = document.querySelector("#btn-multiplication");
const data = [];

btn1.addEventListener('click', (el) => {
    data.push(Number(el.target.value));
    display.textContent += el.target.value;
});
btn2.addEventListener('click', (el) => {
    data.push(Number(el.target.value));
    display.textContent += el.target.value;
});
btn3.addEventListener('click', (el) => {
    data.push(Number(el.target.value));
    display.textContent += el.target.value;
});
btnAdd.addEventListener('click', (el) => {
    data.push(el.target.value);
    display.textContent += el.target.value;
});
btnMulti.addEventListener('click', (el) => {
    data.push(el.target.value);
    display.textContent += el.target.value;
});
btnEqual.addEventListener('click', (el) => {
    display.textContent = eval(display.textContent);
});
clear.addEventListener('click', (el) => {
    display.textContent = '';
});