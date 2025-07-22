// Ce script permet de gérer le système de notation des chauffeurs

// On récupère l'input de type 'hide' oú on va stocker la note du chauffeur
const inputNote = document.getElementById('inputNote');
// On récupere les étoiles pour la note du chauffeur
const allStar = document.querySelectorAll(".star");

// On ajoute un event listener sur chaque étoile pour changer la note du chauffeur
allStar.forEach((star, index) => {
  star.addEventListener("click", () => {
    // On ajout a notre input de type 'hide' la valeur de l'étoile cliqué
    inputNote.value = star.dataset.value;

    // Verification si l'étoile cliqué a déjà la class "active-star"
    const isLastActive =
      index + 1 === document.querySelectorAll(".active-star").length;

    // Si oui, on démarque tous les étoiles
    if (isLastActive) {
      allStar.forEach((s) => s.classList.remove("active-star"));
    }
    // Sinon,
    else {
      // on active les étoiles jusqu'à l'étoile sélectionnée
      for (let i = 0; i <= index; i++) {
        allStar[i].classList.add("active-star");
      }
      // Et on désactive les étoiles suivantes
      for (let i = index + 1; i < allStar.length; i++) {
        allStar[i].classList.remove("active-star");
      }
    }

  })

})