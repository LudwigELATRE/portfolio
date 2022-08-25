"use strict";
window.addEventListener("DOMContentLoaded", (event) => {
  // Navbar shrink function
  var navbarShrink = function () {
    const navbarCollapsible = document.body.querySelector("#mainNav");
    if (!navbarCollapsible) {
      return;
    }
    if (window.scrollY === 0) {
      navbarCollapsible.classList.remove("navbar-shrink");
    } else {
      navbarCollapsible.classList.add("navbar-shrink");
    }
  };

  // Shrink the navbar
  navbarShrink();

  // Shrink the navbar when page is scrolled
  document.addEventListener("scroll", navbarShrink);

  // Activate Bootstrap scrollspy on the main nav element
  const mainNav = document.body.querySelector("#mainNav");
  if (mainNav) {
    new bootstrap.ScrollSpy(document.body, {
      target: "#mainNav",
      offset: 72,
    });
  }

  // Collapse responsive navbar when toggler is visible
  const navbarToggler = document.body.querySelector(".navbar-toggler");
  const responsiveNavItems = [].slice.call(
    document.querySelectorAll("#navbarResponsive .nav-link")
  );
  responsiveNavItems.map(function (responsiveNavItem) {
    responsiveNavItem.addEventListener("click", () => {
      if (window.getComputedStyle(navbarToggler).display !== "none") {
        navbarToggler.click();
      }
    });
  });
});

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
