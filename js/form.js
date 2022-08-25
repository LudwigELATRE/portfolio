"use strict";

/* Formulaire Page Contact */

const nom = document.querySelector("#nom");
const prenom = document.querySelector("#prenom");
const email = document.querySelector("#email");
const sujet = document.querySelector("#sujet");
const message = document.querySelector("#message");

function check(field) {
  field.addEventListener("blur", function () {
    this.value = this.value.trim();
    if (this.value === "") {
      this.style.border = "2px solid red";
      this.nextElementSibling.textContent = "Veuillez remplir le champs";
      this.nextElementSibling.classList.remove("active");
      return false;
    } else {
      this.style.border = "2px solid #119d15";
      this.nextElementSibling.textContent = "";
      this.nextElementSibling.classList.add("active");
    }
  });
}

check(prenom);
check(nom);
check(email);
check(sujet);
check(message);
