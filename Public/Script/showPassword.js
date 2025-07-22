// Script pour afficher et masquer le mot de passe

// Icon du petit carré
let icon = document.getElementById("showPasswordIcon");
// Label qui contient le mot de passe
let password = document.getElementById("floatingPassword");
// le text qui dit "Afficher le mot de passe" ou "Masquer le mot de passe"
let showPasswordText = document.getElementById("showPasswordText");

icon.addEventListener("click", function () {
  // Si on clique l'icon on affiche le mot de passe
  if (password.type == "password") {
    password.type = "text";
    icon.classList.toggle("bi-square");
    icon.classList.toggle("bi-check-square");
    showPasswordText.textContent = "Cacher le mot de passe";
  }
  // Si le mot de passe est déjà visible et qu'on clique l'icon, alors, on le masque
  else {
    password.type = "password";
    icon.classList.toggle("bi-check-square");
    icon.classList.toggle("bi-square");
    showPasswordText.textContent = "Afficher le mot de passe";
  }
});
