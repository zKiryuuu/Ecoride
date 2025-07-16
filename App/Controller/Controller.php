<?php

namespace App\Controller;
// require_once './App/Controller/PageController.php';
use Exception;


class Controller
{
    // Fonction pour gérer le routage
    public function route(): void
    {
        try {
            if (isset($_GET['controller'])) {
                switch ($_GET['controller']) {
                    // Appel du contrôleur page
                    case 'page':
                        $controller = new PageController();
                        $controller->route();
                        break;
                    // Appel du contrôleur covoiturages
                    case 'covoiturages':
                        $controller = new CovoiturageController();
                        $controller->route();
                        break;
                    // Appel du contrôleur user
                    case 'user':
                        $controller = new UserController();
                        $controller->route();
                        break;
                    // Appel du contrôleur auth
                    case 'auth':
                        $controller = new AuthController();
                        $controller->route();
                        break;
                    // Appel du contrôleur voiture
                    case 'voiture':
                        $controller = new VoitureController();
                        $controller->route();
                        break;
                    // Appel du contrôleur preference
                    case 'preferences':
                        $controller = new PreferenceUserController();
                        $controller->route();
                        break;
                    // Appel du controlleur pour l'espace employé
                    case 'employe':
                        $controller = new EmployeController();
                        $controller->route();
                        break;
                    // Appel du controlleur pour l'espace admin
                    case 'admin':
                        $controller = new AdminController();
                        $controller->route();
                        break;
                    // Appel du controlleur pour les API
                    case 'api':
                        $this->apiRoute();
                        break;
                    // Si le contrôleur passe dans l'url n'existe pas
                    default:
                        throw new Exception("Ce contrôleur n'existe pas: " . $_GET['controller']);
                        break;
                }
            }
            // Si il n'y a pas des contôleur dans l'url 
            else {
                // On charge la page d'accueil
                $controller = new PageController();
                $controller->accueil();
            }
        } catch (Exception $e) {
            $this->render("Errors/404", [
                'error' => $e->getMessage()
            ]);
        }
    }

    // Fonction pour appeler à la vue via le path de la page et avec des params specifiques
    protected function render(string $path, array $params = []): void
    {
        // Path du fichier avec la vue
        $filePath = BASE_PATH . "/Templates/" . $path . ".php";

        try {
            // Si le path est introuvable
            if (!file_exists($filePath)) {
                throw new Exception("Le fichier n'existe pas" . $filePath);
            }
            /**
             *  Si le path est trouvé, nous créons des variables à partir du tableau $params 
             *  et on appel la vue*/
            else {
                extract($params);
                require_once $filePath;
            }
        } catch (Exception $e) {
            $this->render(
                "/Errors/default",
                [
                    'error' => $e->getMessage()
                ]
            );
        }
    }

    // Fonction pour gerer le routage de l'API
    private function apiRoute()
    {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                // Action pour obtenir les données du graphique
                case 'getGraphData':
                    $apiController = new ApiController();
                    $apiController->getGraphData();
                    break;
                // Action pour démarrer un covoiturage
                case 'startCovoiturage':
                    $apiController = new ApiController();
                    $apiController->startCovoiturage();
                    break;
                // Action pour indiquer l'arrivée du covoiturage  
                case 'stopCovoiturage':
                    $apiController = new ApiController();
                    $apiController->stopCovoiturage();
                    break;
                // Si l'action passée dans l'url n'existe pas
                default:
                    throw new \Exception("Cette action n'existe pas dans l'API");
            }
        } else {
            // Si il n'y a pas une action dans l'url
            throw new \Exception("Aucune action détectée dans l'API");
        }
    }
}
