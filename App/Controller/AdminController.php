<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CovoiturageRepository;
use App\Repository\UserRepository;
use App\Security\Security;
use App\Security\UserValidator;
use DateTime;
use Exception;

class AdminController extends Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    // Action pour afficher l'espace admin
                    case 'adminEspace':
                        $this->adminEspace();
                        break;
                    // Action pour afficher les graphiques du site
                    case 'adminGraphs':
                        $this->adminGraphs();
                        break;
                    // Si l'action passée dans l'url n'existe pas
                    default:
                        throw new \Exception("Cette action n'existe pas: " . $_GET['action']);
                        break;
                }
            }
            // Si il n'y a pas une action dans l'url 
            else {
                throw new \Exception("Aucune action détectée");
            }
        } // On return la page d'erreur s'il en existe un
        catch (\Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }


    /*
    Exemple d'appel depuis l'url
        ?controller=admin&action=adminEspace
    */
    // Fonction pour afficher l'espace admin
    private function adminEspace()
    {
        // Si l'utilisateur est connecté en tant qu'administrateur
        if (Security::isAdmin()) {
            // repository pour la table User
            $userRepository = new UserRepository;
            // On récupère tous les utilisateurs
            $allUsers = $userRepository->findAllUsers();

            // Si il y a une action de suppression d'un utilisateur
            if (isset($_POST['suspendUser'])) {
                $userId = $_POST['id']; // On récupère l'id de l'utilisateur à suspendre
                // On supprime l'utilisateur
                $userRepository->suspendUser($userId);
                // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
                $_SESSION['message_to_User'] = 'Le compte utilisateur a bien été suspendu.';
                $_SESSION['message_code'] = "success";
            }

            // Fonction pour créer un compte employé
            $employeAccount = $this->createEmployeAccount();

            $this->render(
                "User/adminEspace",
                [
                    'allUsers' => $allUsers,
                    "employePseudoAccount" => $employeAccount['pseudo'],
                    "employeMailAccount" => $employeAccount['mail'],
                    "employePasswordAccount" => $employeAccount['password'],
                    "errors" => $employeAccount['errors']
                ]
            );
        } // Sinon on envoie à la page de connexion
        else {
            header('Location: ?controller=auth&action=logIn');
        }
    }

    // Fonction pour créer un compte employé
    private function createEmployeAccount()
    {
        $errors = [];
        $pseudo = "";
        $mail = "";
        $password = "";
        try {
            $user = new User();
            $UserValidator = new UserValidator();
            $userRepository = new UserRepository();
            $userController = new UserController();
            // Si le formulaire est envoyé, on hydrate l'objet User avec les données passées
            if (isset($_POST['singUp'])) {
                $user->hydrate($_POST);
                $pseudo = $user->getPseudo();
                $mail = $user->getMail();
                $password = $user->getPassword();
                // Pour hasher le mot de passe
                $userController->passwordHasher($user);
                // Pour valider s'il n'y a pas des erreurs dans le formulaire
                $errors = $UserValidator->singUpEmployeValidate($user);
                // S'il n'y a pas des erreurs, on crée l'utilisateur dans la base des données
                if (empty($errors)) {

                    // on crée l'employé dans la base de données
                    $userRepository->createEmployeAccount($user);

                    // On crée cette session pour pouvoir afficher le message de succès, le message_code c'est pour l'icon de SweetAlert
                    $_SESSION['message_to_User'] = "Le compte employé a été créé avec succès.";
                    $_SESSION['message_code'] = "success";
                    // On envoie le json au fetch
                    echo (json_encode(['success' => true, 'message' => 'Compte créé avec succès']));
                    exit;
                } else { // S'il y a des erreurs
                    // On envoie le json au fetch
                    echo (json_encode(['success' => false, 'errors' => $errors]));
                    exit;
                }
            }

            return [
                'pseudo' => $pseudo,
                'mail' => $mail,
                'password' => $password,
                'errors' => $errors
            ];
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }

    /*
    Exemple d'appel depuis l'url
        ?controller=admin&action=adminGraphs
    */
    // Fonction pour afficher les graphiques du site
    private function adminGraphs()
    {
        // Si l'utilisateur est connecté en tant qu'administrateur
        if (Security::isAdmin()) {
            $this->render("User/adminGraphs");
        } // Sinon on envoie à la page de connexion
        else {
            header('Location: ?controller=auth&action=logIn');
        }
    }
}
