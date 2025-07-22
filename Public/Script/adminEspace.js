// Script pour initialiser le tableau des utilisateurs avec la librairie JS DataTable
// new DataTable('#userTable'); // userTable est l'id du tableau des utilisateurs
$('#userTable').DataTable({ // JQuery pour initialiser le tableau et changer la langue
    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
    }
});

// Script pour la creation d'un compte employé despuis l'espace admin
// On récupère le formulaire de création de compte employé
const createEmployeAccountForm = document.getElementById("createEmployeAccountForm");
// On vérifie si le formulaire existe avant d'ajouter l'écouteur d'événement
if(createEmployeAccountForm){
    // On ajoute un écouteur d'événement pour le formulaire
    createEmployeAccountForm.addEventListener("submit", (event) => {
        event.preventDefault() // Empêche le rechargement de la page 
        const formData = new FormData(createEmployeAccountForm) // On récupère les données du formulaire
        const data = new URLSearchParams(formData).toString() // On transforme les données du formulaire en une chaîne de caractères au format URL
    
        // Fetch pour envoyer les données du formulaire au controller UserController.php
        fetch("", {
            method: "POST",
            headers: { // On définit le type de contenu de la requête
                "content-type": "application/x-www-form-urlencoded",
            },
            body: data + '&singUp=1', // On ajoute le paramètre singUp=1 pour récupérer la requête dans le controller
        }).then(response => response.json())
            .then(data => {
                // Si il n'y a pas des erreurs dans le formulaire 
                if (data.success === true) {
                    location.reload(); // On recharge la page pour afficher le message de succès
                }
                else if (data.success === false) { // Si il y a des erreurs dans le formulaire
                    const errors = data.errors; // On récupère les erreurs du formulaire
    
                    // Cacher tous les messages d'erreur existants
                    document.querySelectorAll(".invalid-tooltip").forEach(el => el.classList.add("hidden"));
    
                    // Enlever tous les is-invalid
                    document.querySelectorAll(".form-control").forEach(input => input.classList.remove("is-invalid"));
    
                    // Map entre chaque erreur et l'id du inpur à invalider
                    const fieldMap = {
                        pseudoEmpty: "floatingInput",
                        mailEmpty: "floatingMail",
                        mailUsed: "floatingMail",
                        passwordEmpty: "floatingPassword",
                        passwordLen: "floatingPassword",
                        passwordInfo: "floatingPassword"
                    };
    
                    for (const errorKey in errors) {
                        const message = errors[errorKey];
    
                        // Afficher le message d'erreur dans le bon div
                        const errorElement = document.getElementById(errorKey);
                        if (errorElement) {
                            errorElement.textContent = message;
                            errorElement.classList.remove("hidden");
                        }
    
                        // Ajouter la classe is-invalid au champ correspondant
                        const inputId = fieldMap[errorKey];
                        if (inputId) {
                            const inputElement = document.getElementById(inputId);
                            if (inputElement) {
                                inputElement.classList.add("is-invalid");
                            }
                        }
                    }
                }
            })
            .catch(error => {
                console.error("Erreur lors de la requête :", error);
            });
    })
}

// Pour les tooltips Bootstrap. les icones pour suspendre un compte 
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggleTooltip="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))





