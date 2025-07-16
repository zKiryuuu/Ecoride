<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;

class UserValidator
{
    // Fonction de validation du formulaire pour la création d'un compte utilisateur
    public function singUpValidate(User $userHydrate): array
    {
        // Tableau d'erreurs
        $errors = [];
        // Variable de l'utilisateur passé dans le formulaire 
        $user = $userHydrate;
        // Appel de la classe avec les requêtes SQL
        $userRepository = new UserRepository;
        // Expresión regular pour la verification du mot de passe sécurisé
        $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).{12,}$/';

        // Si le champ d'utilisateur est vide
        if (empty($user->getPseudo())) {
            $errors['pseudoEmpty'] = 'Le champ pseudo ne doit pas être vide';
        }

        // Si le champ du mail est vide
        if (empty($user->getMail())) {
            $errors['mailEmpty'] = "Le champ mail ne doit pas être vide";
        } elseif (!filter_var($user->getMail(), FILTER_VALIDATE_EMAIL)) { // Si le mail n'est pas un mail valide
            $errors['mail'] = "Le mail n\'est pas valide";
        } elseif ($userRepository->findOneByMail($user->getMail())) { // Si le mail est déjà enregistrer dans la base de données
            $errors['mailUsed'] = "Le e-mail est déjà utilisé";
        }

        // Si le champ du mot de passe est vide
        if (empty($user->getPassword())) {
            $errors['passwordEmpty'] = "Le champ mot de passe ne doit pas être vide";
        } elseif (strlen($_POST['password']) < 12) { // Si le mot de passe a mois de 12 caractères
            $errors['passwordLen'] = "Le mot de passe doit comporter au moins 12 caractères";
        } elseif (! preg_match($regex, $_POST['password'])) { // Si le mot de passe ne respecte pas le regex
            $errors['passwordInfo'] = "Votre mot de passe doit contenir :
	                                Une lettre majuscule et une lettre minuscule,
	                                un chiffre et
	                                un caractère spécial";
        }

        // Si l'option du role est vide
        if (empty($user->getRoleId())) {
            $errors['roleEmpty'] = "Vous devez choisir un role";
        }

        return $errors;
    }

    // Fonction de validation du formulaire pour la création d'un compte employé
    public function singUpEmployeValidate(User $userHydrate): array
    {
        // Tableau d'erreurs
        $errors = [];
        // Variable de l'utilisateur passé dans le formulaire 
        $user = $userHydrate;
        // Appel de la classe avec les requêtes SQL
        $userRepository = new UserRepository;
        // Expresión regular pour la verification du mot de passe sécurisé
        $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).{12,}$/';

        // Si le champ d'utilisateur est vide
        if (empty($user->getPseudo())) {
            $errors['pseudoEmpty'] = 'Le champ pseudo ne doit pas être vide';
        }

        // Si le champ du mail est vide
        if (empty($user->getMail())) {
            $errors['mailEmpty'] = "Le champ mail ne doit pas être vide";
        } elseif (!filter_var($user->getMail(), FILTER_VALIDATE_EMAIL)) { // Si le mail n'est pas un mail valide
            $errors['mail'] = "Le mail n\'est pas valide";
        } elseif ($userRepository->findOneByMail($user->getMail())) { // Si le mail est déjà enregistrer dans la base de données
            $errors['mailUsed'] = "Le e-mail est déjà utilisé";
        }

        // Si le champ du mot de passe est vide
        if (empty($user->getPassword())) {
            $errors['passwordEmpty'] = "Le champ mot de passe ne doit pas être vide";
        } elseif (strlen($_POST['password']) < 12) { // Si le mot de passe a mois de 12 caractères
            $errors['passwordLen'] = "Le mot de passe doit comporter au moins 12 caractères";
        } elseif (! preg_match($regex, $_POST['password'])) { // Si le mot de passe ne respecte pas le regex
            $errors['passwordInfo'] = "Votre mot de passe doit contenir :
	                                Une lettre majuscule et une lettre minuscule,
	                                un chiffre et
	                                un caractère spécial";
        }

        return $errors;
    }

    // Fonction pour valider le formulaire de connexion
    public function logInValidate(string $userMail): array
    {
        // Tableau d'erreurs 
        $errors = [];

        // Si le champ du mail est vide
        if (empty($userMail)) {
            $errors['mail'] = "Vous devez mettre une adresse e-mail";
        }

        return $errors;
    }

    // Fonction pour vérifier le mot de passe passé dans le formulaire et le mot de passe hashé dans la bdd
    public function passwordVerify(User $user)
    {
        if ($user && password_verify($_POST['password'], $user->getPassword())) {
            return true;
        } else {
            return false;
        }
    }

    // Fonction pour récuperer et valider la photo de l'utilsateur
    public function UserPhotoValidate(User $user)
    {
        $errors = [];

        if (isset($_FILES['photo'])) {
            $fileName = $_FILES['photo']['name'];
            $fileSize = $_FILES['photo']['size'];
            $fileError = $_FILES['photo']['error'];
            $fileTempName = $_FILES['photo']['tmp_name'];

            // Pour séparer le nom du fichier selon le '.', afin de trouver l'extention du fichier
            $fileExtension = explode(".", $fileName);
            // Pour convertir l'extention du fichier en lower case
            $fileExtLowerCase = strtolower(end($fileExtension));
            // Les extentions des images qui sont acceptées
            $fileExtAllowed = ["jpg", "jpeg", "png", "webp"];
            // Pour définir le taille maxime des images
            $maxFileSize = 2 * 1024 * 1024; // 2 MB

            // Pour valider l'image selon des conditions
            //S'il y a pas des erreurs,
            if ($fileError === 0) {
                // Si l'extention du fichier est acceptée,
                if (in_array($fileExtLowerCase, $fileExtAllowed)) {
                    // Si la taille de l'image est inferieure à 2 Mo
                    if ($fileSize < $maxFileSize) {
                        // Nouveau nom de l'image avec une unique id et l'extention de l'image
                        $fileNewName = uniqid("", true) . "." . $fileExtLowerCase;
                        // On passe le uniqId de la photo à l'objet User
                        $user->setPhotoUniqId($fileNewName);
                        // Le folder de déstination
                        $folderDestination = './Uploads/User/' . $fileNewName;
                        // Déplacement de l'image vers le folder avec les images des utilisateurs
                        move_uploaded_file($fileTempName, $folderDestination);
                    } else {
                        $errors['fileSizeError'] = "L'image est trop grande. Taille maximale autorisée : 2 Mo";
                    }
                } else {
                    $errors['fileExtError'] = "Format d'image non autorisé. Seuls les fichiers JPG, PNG ou WEBP sont acceptés";
                }
            } else {
                $errors['fileError'] = "Erreur lors du téléchargement de l'image";
            }

            // Si l'utilisateur est un chauffeur et n'a pas choisi une photo, alors erreur
            if ($user->getRoleId() == "2" || $user->getRoleId() == "3") {
                if (empty($user->getPhoto())) {
                    $errors['fileEmpty'] = "Vous devez choisir votre image d'utilisateur";
                }
            }
        }

        return $errors;
    }
}
