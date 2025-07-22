// Script pour afficher le formulaire pour enregistrer une nouvelle préférence dans la page du profile

// L'icon d'ajouter
let newPrefIcon = document.getElementById('newPrefIcon')
// Le formulaire pour créer une nouvelle préférence
let personalPreference = document.getElementById('personalPreference')

// Si on clique dans l'icon d'ajouter, alors on affiche le formualaire pour créer une nouvelle préférence
newPrefIcon.addEventListener('click', () => {
    personalPreference.classList.toggle('hidden')
})

// Script pour afficher la deuxième partie du formulaire d'ajouts des préférences pour le chauffuer

let preferencesForm = document.getElementById('preferencesForm');
let button = document.getElementById('btnPreferences')

button.addEventListener('click', () => {
    preferencesForm.classList.remove('hidden')
})



