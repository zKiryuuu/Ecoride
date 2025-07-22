// Script pour agrandir la section avec la barre de recherche des covoiturages
// s'il y a d'erreurs dans le formulaire 

// Les messages d'erreurs
let errors = document.querySelectorAll('.invalid-tooltip') ?? 0;
// La section avec le slogan et la barre de recherche
let slogan = document.getElementById('slogan');
let searchBar = document.getElementById('searchBar');

// Le message qui s'affiche si on ne trouve pas un covoiturage dans la date indiquée par l'utilisateur
let covoiturageNotFound = document.getElementById('covoiturageNotFound');

// Si on affiche d'erreurs, alors, on ajout les classes avec le style correspondant
if(errors.length > 0 || covoiturageNotFound){
    slogan.classList.add('slogan-error')
    searchBar.classList.add('search-bar-error')
} else { // Sinon, on supprime les classes d'erreurs
    slogan.classList.remove('slogan-error')
    searchBar.classList.remove('search-bar-error')
}