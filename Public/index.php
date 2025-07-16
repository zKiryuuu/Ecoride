<?php
// Definition de un constante pour le path depuis l'index.php
define('_ROOTPATH_', __DIR__);
// Pour charger les namespaces
require_once __DIR__ . '/../vendor/autoload.php';

/** Paramètres de la session de l'utilisateur
 *  Sécurise le cookie de session avec httponly
 *  */

session_set_cookie_params([
    'lifetime' => 86400, //24 heures
    'path' => '/',
    'domain' => $_SERVER['SERVER_NAME'],
    'httponly' => true
]);
// Initialisation de la session
session_start();

// On definit le path pour appeler les fichier depuis l'index, afin d'eviter des erreurs dans le serveur
define('BASE_PATH', dirname(__DIR__));

// Pour le système du routage
use App\Controller\Controller;

$controller = new Controller();
$controller->route();

