<?php
require_once BASE_PATH . '/vendor/autoload.php';

// Dans ce fichier on charge les variables d'environement avec la Bibliotheque vlucas/phpdotenv
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();
return $_ENV;