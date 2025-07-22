// Ce script permet de gérer l'ouverture et la fermeture du menu mobile

document.addEventListener("DOMContentLoaded", function () {
  // On sélectionne le bouton qui ouvre/ferme le menu mobile (le bouton burger)
  const mobileMenuBtn = document.querySelector(".mobile-menu-btn");

  // On sélectionne le menu mobile (celui qui s'affiche en responsive)
  const mobileMenu = document.querySelector(".mobile-menu");

  // On ajoute un écouteur d'événement "click" sur le bouton burger
  mobileMenuBtn.addEventListener("click", function () {
    // Lorsqu'on clique, on ajoute ou retire la classe "active" au menu mobile
    // Cela permet de l'afficher ou le masquer (via le CSS)
    mobileMenu.classList.toggle("active");

    // On ajoute ou retire la classe "open" au bouton burger
    // Cela permet de changer son apparence (en croix, par exemple)
    mobileMenuBtn.classList.toggle("open");
  });
});
