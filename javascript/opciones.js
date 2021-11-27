const radio1_btn = document.querySelector("#radio-1");
const radio2_btn = document.querySelector("#radio-2");
const radio3_btn = document.querySelector("#radio-3");
const radio4_btn = document.querySelector("#radio-4");
const container = document.querySelector(".contenedor");

radio1_btn.addEventListener('click', () => {
    container.classList.add("sign-up-mode");
});

radio2_btn.addEventListener('click', () => {
    container.classList.remove("sign-up-mode");
});

radio3_btn.addEventListener('click', () => {
    container.classList.remove("sign-up-mode");
});

radio4_btn.addEventListener('click', () => {
    container.classList.remove("sign-up-mode");
});