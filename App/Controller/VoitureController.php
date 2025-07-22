<?php

namespace App\Controller;

use App\Entity\PreferenceUser;
use App\Entity\Voiture;
use App\Repository\PreferenceUserRepository;
use App\Repository\VoitureRepository;
use App\Security\Security;
use App\Security\VoitureValidator;
use Exception;

class VoitureController extends Controller
{

    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    // Action pour créer une nouvelle voiture
                    case 'carInscription':
                        $this->carInscription();
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
        ?controller=voiture&action=carInscription
    */

    // Fonction pour enregistrer une voiture
    protected function carInscription()
    {
        // Si l'utilisateur est connecté 
        if (Security::isLogged()) {
            // Tableau d'erreurs
            $errors = [];
            // L'id de l'utilisateur
            $user_id = $_SESSION['user']['id'];
            // Varibles pour autocompléter le formulaire
            $immatriculation = "";
            $dateImmatriculation = "";
            $marque = "";
            $modele = "";
            $couleur = "";

            try {
                $voiture = new Voiture;
                $voitureRepository = new VoitureRepository;
                $voitureValidator = new VoitureValidator;

                // Si le formulaire est envoyé, on hydrate l'objet Voiture avec les données passées
                if (isset($_POST['carInscription'])) {
                    $voiture->hydrate($_POST);
                    $immatriculation = $voiture->getImmatriculation();
                    $dateImmatriculation = $voiture->getDatePremiereImmatriculation();
                    $marque = $voiture->getMarque();
                    $modele = $voiture->getModele();
                    $couleur = $voiture->getCouleur();
                    // Pour valider s'il n'y a pas des erreurs dans le formulaire
                    $errors = $voitureValidator->newCarValidate($voiture);
                    // S'il n'y a pas des erreurs, on crée la voiture dans la basse des données
                    if (empty($errors)) {
                        $voitureRepository->createCar($voiture, $user_id);
                        // Pour trouver tous les voitures de l'utilisateur
                        $cars = $voitureRepository->findAllCarsByUserId($user_id);
                        // Si l'utilisateur a 2 ou plus de 2 voitures, alors on envoi vers la page d'accueil
                        if (count($cars) >= 2) {
                            // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
                            $_SESSION['message_to_User'] = "Voiture crée avec succès";
                            $_SESSION['message_code'] = "success";
                            // On redirige vers la page d'accueil
                            header('location: ?controller=page&action=accueil');
                            exit();
                        } else {
                            // On evoi vers la page pour enregistrer les préférences
                            header('Location: ?controller=preferences&action=preferencesInscription');
                        }
                    }
                }
            } catch (Exception $e) {
                $this->render("Errors/404", [
                    'error' => $e->getMessage()
                ]);
            }
            $this->render(
                "Voiture/voiture-inscription",
                [
                    "errors" => $errors,
                    "immatriculation" => $immatriculation,
                    "dateImmatriculation" => $dateImmatriculation,
                    "marque" => $marque,
                    "modele" => $modele,
                    "couleur" => $couleur
                ]
            );
        } // Sinon on envoie à la page de connexion
        else {
            header('Location: ?controller=auth&action=logIn');
        }
    }
}
