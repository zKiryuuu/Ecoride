<?php

namespace App\Controller;

use App\Entity\Covoiturage;
use App\Repository\AvisRepository;
use App\Repository\CovoiturageRepository;
use App\Repository\Repository;
use App\Security\CovoiturageValidator;
use DateTime;
use Exception;

class PageController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    // Action pour afficher la page d'accueil
                    case 'accueil':
                        $this->accueil();
                        break;
                    // Action pour afficher la page de contact
                    case 'contact':
                        $this->contact();
                        break;
                    // Action pour afficher la page UI
                    case 'ui':
                        $this->ui();
                        break; 
                    // Action pour afficher la page TEST
                    case 'test':
                        $this->test();
                        break;   
                    // Action pour afficher la page dans laquelle le passager indique si le covoiturage s'est bien passé
                    case 'validateCovoiturage':
                        $this->validateCovoiturage();
                        break;
                    // Action pour afficher la page avec les mentions legales
                    case 'legalMentions':
                        $this->legalMentions();
                        break;                   
                    // Si l'action passee dans l'url n'existe pas
                    default:
                        throw new Exception("Cette action n'existe pas: " . $_GET['action']);
                        break;
                }
            }
            // Si il n'y a pas des action dans l'url 
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
        ?controller=page&action=accueil
    */
    // Fonction pour afficher la page d'accueil
    protected function accueil()
    {
        // Fonction de la barre de recherche pour chercher des covoiturages
        $this->searchCovoiturage();
        $this->render(
            "Page/accueil",
            [
                'dateDepart' => $this->searchCovoiturage()[0],
                'adresseDepart' => $this->searchCovoiturage()[1],
                'adresseArrivee' => $this->searchCovoiturage()[2],
                'errors' => $this->searchCovoiturage()[3],
                'covoiturageCloser' => $this->searchCovoiturage()[4],
                'newDateDepart' => $this->searchCovoiturage()[5],
                'noCovoiturageFoundMsg' => $this->searchCovoiturage()[6]
            ]
        );
    }
    // Fonction de la barre de recherche
    protected function searchCovoiturage()
    {
        $covoiturage = new Covoiturage;
        $covoiturageRepository = new CovoiturageRepository;
        $covoiturageValidator = new CovoiturageValidator;
        $errors = [];
        // Variables pour contenir les données du formulaire
        $dateDepart = "";
        $adresseDepart = "";
        $adresseArrivee = "";
        $covoiturageCloser = null;
        $newDateDepart = null;
        $noCovoiturageFoundMsg = "";

        // Si on envoi le formulaire de recherche, ....
        if (isset($_GET['search'])) {
            // On Hydrate l'objet de la classe Covoiturage
            $covoiturage->hydrate($_GET);
            // On enregistre les valeurs passées dans le formulaire dans nos variables
            //si le champ de la date n'est pas vide, alors on le récupére, sinon, on le laisse vide
            $dateDepart = (!empty($_GET['date_heure_depart'])) ? $covoiturage->getDateHeureDepart()->format('Y-m-d') : "";
            $adresseDepart = $covoiturage->getAdresseDepart();
            $adresseArrivee = $covoiturage->getAdresseArrivee();
            // Fonction pour chercher avec les donées passées 
            $covoiturages = $covoiturageRepository->searchCovoiturageByDateAndAdresse($adresseDepart, $adresseArrivee, $dateDepart);
            // Pour Vérifier les erreurs dans le formulaire
            $errors =  $covoiturageValidator->searchCovoiturageValidate($dateDepart, $adresseDepart, $adresseArrivee);
            // S'il n'y a pas des erreurs, ....
            if (empty($errors)) {
                // Si on trouve des résultats,
                // on envoi vers la page de tous les covoiturages et on affiche les résultats 
                if ($covoiturages) {
                    // pour enregistrer les covoiturages trouvés dans une session, 
                    // afin de pouvoir passer les donées ver une nouvelle page 
                    $_SESSION['covoiturages'] = $covoiturages;
                    header('location: ?controller=covoiturages&action=showAll');
                } // Si on ne trouve pas des covoiturages dans la date passée, alors
                else {
                    // On appel la fonction pour chercher le covoiturage le plus proche à la date donnée par l'user
                    $searchCloser = $this->searchCloserCovoiturage($dateDepart, $covoiturageRepository, $adresseDepart, $adresseArrivee);
                    // si on trouve des covoiturages proche à la date donnée
                    if (!empty($searchCloser)) {
                        // On enregistre les données dans la session
                        $covoiturageCloser = $_SESSION['covoiturageCloser'];
                        // On instance un objet DateTime, pour la nouvelle date à proposer à l'utilisateur
                        $newDateDepart = new DateTime($covoiturageCloser['date_heure_depart']);
                    } // Si on ne trouve pas de covoiturages avec les données passées
                    else {
                        // On passe le message qui va s'afficher à l'utlisateur
                        $noCovoiturageFoundMsg = "Désolé, aucun covoiturage n'a été trouvé pour ces adresses.
                        <br> Essayez de modifier votre recherche ou de choisir un autre point de départ ou d'arrivée.";
                    }
                }
            }
        }
        return [$dateDepart, $adresseDepart, $adresseArrivee, $errors, $covoiturageCloser, $newDateDepart, $noCovoiturageFoundMsg];
    }
    // Fonction pour chercher le covoiturage le plus proche à la date donnée par l'user
    protected function searchCloserCovoiturage(string $dateDepart, CovoiturageRepository $covoiturageRepository, string $adresseDepart, string $adresseArrivee)
    {
        // On instance un objet DateTime pour la date donnée par l'utilisateur
        $dateSerched = new DateTime($dateDepart);
        // Pour récupérer le timestamp de cette date 
        $dateSerchedTimestamp = $dateSerched->getTimestamp();

        // Fonction pour chercher tous les covoiturages selon les adresse de départ et d'arrivée
        // $allCovoiturages = $covoiturageRepository->searchAllCovoituragesByAdresse($adresseDepart, $adresseArrivee);
        $allCovoiturages = $covoiturageRepository->searchCovoiturageByDateAndAdresse($adresseDepart, $adresseArrivee);

        // Variable qui va contenir le covoiturage plus proche trouvé
        $covoiturageCloser = null;
        // Variable qui contient le int maximum possible
        $maxDifference = PHP_INT_MAX;

        // On parcourt le tableau avec les covoiturages trouvés
        foreach ($allCovoiturages as $covoiturage) {
            // On instance un objet DateTime pour les dates de tous les covoiturages trouvés
            $dateFound = new DateTime($covoiturage['date_heure_depart']);
            // Pour récupérer le timestamp de chaque date 
            $dateDepartTimestamp = $dateFound->getTimestamp();

            // On récupere la difference en timestamp de chaque date avec la date donées par l'user
            $difference = abs($dateDepartTimestamp - $dateSerchedTimestamp);

            // Si la difference est mineur à la difference précédente, alors, on change la valeur de la même
            // et on change la valeur de le covoiturage plus proche par rapport à la date 
            if ($difference < $maxDifference) {
                $maxDifference = $difference;
                $covoiturageCloser = $covoiturage;
            }
        }
        // pour enregistrer les covoiturages trouvés dans une session, 
        // afin de pouvoir passer les donées ver une nouvelle page 
        return $_SESSION['covoiturageCloser'] = $covoiturageCloser;
    }

    /*
    Exemple d'appel depuis l'url
        ?controller=page&action=contact
    */
    // Fonction pour afficher la page de contact
    protected function contact()
    {
        $this->render("Page/contact");
    }

    
    // Fonction pour afficher la page UI
    protected function ui()
    {
        $this->render("Page/ui");
    }    

    // Fonction pour afficher la page Test
    protected function test()
    {
        $this->render("Page/test");
    }    

    /*
    Exemple d'appel depuis l'url
        ?controller=page&action=validateCovoiturage
    */
    // Fonction pour afficher la page dans laquelle le passager indique si le covoiturage s'est bien passé
    protected function validateCovoiturage()
    {
        try {
            // On récupere les id passés dans l'url, et on les dechiffre
            $passagerId = CovoiturageController::decryptUrlParameter($_GET['passagerId']);
            $covoiturageId = CovoiturageController::decryptUrlParameter($_GET['covoiturageId']);

            // On appel le repository pour la classe Covoiturage
            $covoiturageRepository = new CovoiturageRepository;
            // On appel le repository pour les avis 
            $avisRepository = new AvisRepository;
            // Pour valider le fomulaire de l'avis et la note
            $covoiturageValidator = new CovoiturageValidator;
            // Pour enregistrer les erreurs du formulaire
            $errors = [];

            // Variables pour enregistrer les détails de l'avis et la note
            $avisTitle =  "";
            $avisDescription = "";
            $avisNote = null;
            $questionRadioYes = false;
            $questionRadioNo = false;
            $driverNoteArray = [];


            // Si on envoi le formulaire de validation du covoiturage, et le passager indique que le covoiturage s'est bien passé
            if (isset($_POST["validateCovoiturageForm"]) && $_POST['questionRadio'] == "oui") {
                // On récupere les détails du covoiturage
                $covoiturageDetails = $covoiturageRepository->searchCovoiturageDetailsById($covoiturageId);
                $covoituragePrice = $covoiturageDetails[0]['prix']; // prix du covoiturage
                $driverId = $covoiturageDetails[0]['user_id']; // l'id du chauffeur
                $questionRadioYes = ($_POST['questionRadio'] == "oui"); // pour savoir si le passager a répondu oui ou non à la question
                $questionRadioNo = ($_POST['questionRadio'] == "non"); // pour savoir si le passager a répondu oui ou non à la question

                // Fonction pour mettre à jour les crédits du chauffeur
                $covoiturageRepository->updateDriverCredits($covoituragePrice, $driverId);

                // Fonction pour mettre à jour le statut de la participation du passager au covoiturage
                // 4 = Validé
                $covoiturageRepository->updateUserCovoiturageStatut($passagerId, $covoiturageId, 4);

                // Variables pour enregistrer les détails de l'avis
                $avisTitle = $_POST['titre'];
                $avisDescription = $_POST['avis'];
                $avisNote = $_POST['note'];
                // Validation des champs de l'avis et de la note
                $errors = $covoiturageValidator->validateCovoiturageFinished($avisTitle, $avisDescription, $avisNote);

                // La note du chauffeur
                $driverNote = $_POST['note'];
                // on transforme la note du chauffeur en un tableau d'entier
                $driverNoteInt = (int)$driverNote;
                for ($i = 1; $i <= $driverNoteInt; $i++) {
                    $driverNoteArray[] = $i;
                }

                // Si le passager a rempli les champs de l'avis et de la note
                if (empty($errors)) {
                    // Fonction pour ajouter l'avis et la note du passager au chauffeur en mongoDB
                    $avisRepository->insertAvisAndNote(
                        $avisTitle,
                        $avisDescription,
                        $avisNote,
                        $passagerId,
                        $driverId,
                        $covoiturageId
                    );
                    // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
                    $_SESSION['message_to_User'] = "Merci pour votre avis !</br>Votre note et commentaire ont bien été enregistrés et seront examinés par notre équipe.";
                    $_SESSION['message_code'] = "success";
                    // On redirige vers la page d'accueil
                    header('location: ?controller=page&action=accueil');
                    exit();
                } // Si le passager n'a pas rempli les champs de l'avis et de la note, on affiche le message de success et on le redirige vers la page d'accueil 
                elseif (count($errors) == 3) {
                    // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
                    $_SESSION['message_to_User'] = "Merci pour votre retour !</br>Nous sommes ravis que votre trajet se soit bien déroulé.";
                    $_SESSION['message_code'] = "success";
                    // // On redirige vers la page d'accueil
                    header('location: ?controller=page&action=accueil');
                    exit();
                }
            } // Si le passager indique que le covoiturage NE S'EST PAS bien passé
            elseif (isset($_POST["validateCovoiturageForm"]) && $_POST['questionRadio'] == "non") {
                // On récupere le commentaire
                $commentaire = $_POST['commentaire'];
                // Pour chercher l'id de la participation d'un passager dans un covoiturage. (Table : User_Covoiturages)
                $userCovoiturageId = $covoiturageRepository->searchUserCovoiturageId($passagerId, $covoiturageId);
                $userCovoiturageId = $userCovoiturageId['id'];
                // Fonction pour enregistrer le commentaire dans la bdd
                $covoiturageRepository->addCommentaireToCovoiturage($commentaire, $userCovoiturageId);
                // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
                $_SESSION['message_to_User'] = "Merci pour votre retour !</br>Nous allons examiner votre commentaire et contacter le chauffeur si nécessaire.";
                $_SESSION['message_code'] = "success";
                // // On redirige vers la page d'accueil
                header('location: ?controller=page&action=accueil');
                exit();
            }
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }


        $this->render(
            "Page/validate-covoiturage",
            [
                "errors" => $errors,
                "avisTitle" => $avisTitle,
                "avisDescription" => $avisDescription,
                "questionRadioYes" => $questionRadioYes,
                "questionRadioNo" => $questionRadioNo,
                "driverNoteArray" => $driverNoteArray,
            ]
        );
    }

    /*
    Exemple d'appel depuis l'url
        ?controller=page&action=legalMentions
    */
    // Fonction pour afficher les mentions légales
    protected function legalMentions()
    {
        $this->render("Page/mentions-legales");
    }
}
