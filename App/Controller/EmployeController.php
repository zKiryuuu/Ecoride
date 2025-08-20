<?php

namespace App\Controller;

use App\Repository\AvisRepository;
use App\Repository\CommentRepository;
use App\Repository\CovoiturageRepository;
use App\Repository\UserRepository;
use App\Security\Security;
use DateTime;
use Exception;

class EmployeController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    // Action pour valider ou refuser les avis des chauffeurs
                    case 'validateAvisAndComments':
                        $this->validateAvisAndComments();
                        break;
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
        ?controller=employe&action=validateAvisAndComments
    */
    // Fonction pour valider ou refuser les avis des chauffeurs
    private function validateAvisAndComments()
    {
        // Si l'utilisateur est connecté en tant qu'employée
        if (Security::isEmploye()) {
            // Repositories
            $avisRepository = new AvisRepository;
            $userRepository = new UserRepository;
            $commentRepository = new CommentRepository;

            // Tous les avis et les notes des chauffeurs 
            $allAvisAndNotesObject = $avisRepository->findAllAvisAndNotes();

            // Pour convertir l'objet mongo en array
            $allAvisAndNotes = iterator_to_array($allAvisAndNotesObject);

            // Function pour valider ou refuser les avis et notes
            $avisNotesFunction = $this->validateAvisAndNote($allAvisAndNotes, $avisRepository, $userRepository);

            // Tous les commentaires des covoiturages signalés
            $allComments = $commentRepository->searchAllComments();

            // Function pour visualiser les commentaires de tous les covoiturages signalés
            $commentsFunction = $this->ValidateComments($allComments, $commentRepository, $userRepository);

            $this->render(
                'User/employeEspace',
                [
                    "allAvisAndNotes" => $allAvisAndNotes,
                    "passagerName" => $avisNotesFunction[0],
                    "driverName" => $avisNotesFunction[1],
                    "allComments" => $allComments,
                    "passagerNameComments" => $commentsFunction[0],
                    "driverNameComments" => $commentsFunction[1],
                    "dateDepartFormatted" => $commentsFunction[2],
                    "dateArriveeFormatted" => $commentsFunction[3],
                ]
            );
        } // Sinon on envoie à la page de connexion
        else {
            header('Location: ?controller=auth&action=logIn');
        }
    }

    // Fonction pour valider ou refuser les avis et notes
    private function validateAvisAndNote(array $allAvisAndNotes, AvisRepository $avisRepository, UserRepository $userRepository): array
    {
        // Pour parcourir le tableau des avis et notes
        foreach ($allAvisAndNotes as $avisAndNote) {
            // Toute l'info de l'avis
            $avisId = (string) $avisAndNote['_id']; // L'id de l'avis
            $passagerId = $avisAndNote['user_id_auteur']; // L'id du passager
            $driverId = $avisAndNote['user_id_cible']; // L'id du chauffeur
            $passagerName[$avisId] = $userRepository->findUserById($passagerId); // Le pseudo du passager
            $driverName[$avisId] =  $userRepository->findUserById($driverId); // Le pseudo du chauffeur
        }
        // Si l'employé valide l'avis, alors ....
        if (isset($_POST['avisValidated'])) {
            $avisStatut = $_POST['avisValidated']; // On récupere le statut, donc = 1 : True
            $avisId = $_POST['avis_id']; // On récupere l'id de l'avis passe dans le formulaire
            $avisRepository->updateAvisStatut($avisStatut, $avisId);
            // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = 'L’avis a été validé avec succès.</br> Il est maintenant visible publiquement.';
            $_SESSION['message_code'] = "success";
        } // Si l'employé refuse l'avis, alors ... 
        elseif (isset($_POST['avisRefused'])) {
            $avisStatut = $_POST['avisRefused']; // On récupere le statut, donc = 0 : False
            $avisId = $_POST['avis_id']; // On récupere l'id de l'avis passe dans le formulaire
            $avisRepository->updateAvisStatut($avisStatut, $avisId);
            // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
            $_SESSION['message_to_User'] = 'L’avis a été refusé.</br> Il ne sera pas publié sur la plateforme.';
            $_SESSION['message_code'] = "info";
        }
        // On retourne le tableau avec les pseudos des passagers et des chauffeurs
        return [$passagerName, $driverName];
    }

    // Fonction pour visualiser les commentaires de tous les covoiturages signalés
    private function ValidateComments(array $allComments, CommentRepository $commentRepository, UserRepository $userRepository)
    {
        // Pour parcourir le tableau des commentaires
        foreach ($allComments as $comment) {
            // Toute l'info de l'avis
            $commentId = $comment['commentaire_id']; // L'id de l'avis
            $passagerId = $comment['passager_id']; // L'id du passager
            $driverId = $comment['driver_id']; // L'id du chauffeur
            $passagerName[$commentId] = $userRepository->findUserById($passagerId); // Le pseudo du passager
            $driverName[$commentId] =  $userRepository->findUserById($driverId); // Le pseudo du chauffeur

            // On récupere la date de départ et d'arrivée et on les formate
            $dateDepart = new DateTime($comment['date_heure_depart']);
            $dateArrivee = new DateTime($comment['date_heure_arrivee']);
            $dateDepartFormatted[$commentId] = $dateDepart->format('d/m/Y à H\h:i');
            $dateArriveeFormatted[$commentId] = $dateArrivee->format('d/m/Y à H\h:i');

            // echo ('<br>');
            // // var_dump($comment['passager_pseudo']);
            // var_dump($dateDepartFormatted[1]);
            // echo ('<br>');
        }


        // On retourne le tableau avec les pseudos des passagers et des chauffeurs
        return [$passagerName, $driverName, $dateDepartFormatted, $dateArriveeFormatted];
    }
}
