// Script pour dynamiser la page de l'espace employé
// Pour récuperer les éléments
const showAvis = document.getElementById('showAvis')
const showComments = document.getElementById('showComments')
const showAvisBtn = document.getElementById('showAvisBtn')
const showCommentsBtn = document.getElementById('showCommentsBtn')
const avisSection = document.getElementById('avisSection')
const commentsSection = document.getElementById('commentsSection')

// Fonction pour afficher ou masquer la section correspondante et
// activer ou désactiver le bouton correspondant
function toggleClass(activeBtn, inactiveBtn, showSection, hideSection) {
    showSection.classList.remove('hidden')
    hideSection.classList.add('hidden')

    activeBtn.classList.add('active')
    inactiveBtn.classList.remove('active')
}

showAvis.addEventListener('click', () => {
    toggleClass(showAvisBtn, showCommentsBtn, avisSection, commentsSection)
})

showComments.addEventListener('click', () => {
    toggleClass(showCommentsBtn, showAvisBtn, commentsSection, avisSection)
})



