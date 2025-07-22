<?php

namespace App\Controller;

use App\Entity\PreferenceUser;
use App\Repository\PreferenceUserRepository;
use App\Security\PreferenceUserValidator;
use Exception;

class PreferenceUserController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    // Action pour créer les préférences du chauffeur
                    case 'preferencesInscription':
                        $this->preferencesInscription();
                        break;
                    // Si l'action passée dans l'url n'existe pas
                    default:
                        throw new Exception("Cette action n'existe pas: " . $_GET['action']);
                        break;
                }
            }
            // Si il n'y a pas une action dans l'url 
            else {
                throw new \Exception("Aucune action détectée");
            }
        } // On return la page d'erreur s'il en existe un
        catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }

    /*
    Exemple d'appel depuis l'url
        ?controller=preferences&action=preferencesInscription
    */
    // Fonction pour enregistrer une nouvelle préférence
    public function preferencesInscription()
    {
        // Tableau d'erreurs
        $errors = [];
        $errors2 = [];
        // L'id de l'utilisateur
        $user_id = $_SESSION['user']['id'];

        try {
            $preference = new PreferenceUser;
            $preference2 = new PreferenceUser;
            $preferenceRepository = new PreferenceUserRepository;
            $preferenceValidator = new PreferenceUserValidator;
            // Si le preimère formulaire est envoyé, on hydrate l'objet Preference avec les données passées
            if (isset($_POST['prefInscription1'])) {
                $preference->hydrate($_POST);
                // Pour la validation des erreurs
                $errors = $preferenceValidator->newPreferenceValidator($preference);
                // S'il n'y a pas des erreurs, on crée la préférence dans la base des données
                if (empty($errors)) {
                    $preferenceRepository->createPreference($preference, $user_id);
                }
            }
            // Si le deuxième formulaire est envoyé, on hydrate l'objet Preference avec les données passées
            if (isset($_POST['prefInscription2'])) {
                $preference2->hydrate($_POST);
                // Pour la validation des erreurs
                $errors2 = $preferenceValidator->newPreferenceValidator($preference2);
                // S'il n'y a pas des erreurs, on crée la préférence dans la base des données
                if (empty($errors2)) {
                    $preferenceRepository->createPreference($preference2, $user_id);
                    // On envoi vers la page d'accueil
                    header('Location: ?controller=page&action=accueil');
                }
            }

            // Pour enregistrer une nouvelle préférence personnelle
            $personalPreference = new PreferenceUser;
            if (isset($_POST['newPersonalPreference'])) {
                // On hydrate l'objet avec les données passées
                $personalPreference->hydrate($_POST);
                // Pour la créer dans la base de données 
                $preferenceRepository->createPreference($personalPreference, $user_id);
                // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
                $_SESSION['message_to_User'] = "Nouvelle préférence sauvegardée";
                $_SESSION['message_code'] = "success";
                // On envoi vers la page d'accueil
                header('Location: ?controller=user&action=profil');
                exit();
            }
            
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }

        $this->render("PreferencesUser/preferences-inscription", [
            'errors' => $errors,
            'errors2' => $errors2,
            'preference' => $preference,
            'preference2' => $preference2
        ]);
    }
}
