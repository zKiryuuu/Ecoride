// Script pour afficher le formulaire d'inscription pour les chauffeurs

// Le formulaire d'inscription pour les chauffeurs
let driverForm = document.getElementById("driverForm");
// le select avec les roles des utilisateurs
let roleSelect = document.getElementById("roleSelect");

// Fonction pour afficher ou masquer le formulaire
function updateFormVisibility() {
  if (roleSelect.value == "2" || roleSelect.value == "3") {
    driverForm.classList.remove("non-chauffeur");
  } else {
    driverForm.classList.add("non-chauffeur");
  }
}

// Vérifier la sélection au chargement de la page
document.addEventListener("DOMContentLoaded", updateFormVisibility);

// Écouter les changements de sélection
roleSelect.addEventListener("change", updateFormVisibility);

