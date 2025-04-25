const sign_in_btn = document.querySelector("#iniciar-sesion-btn");
const sign_up_btn = document.querySelector("#registrar-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("registrar-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("registrar-mode");
});

