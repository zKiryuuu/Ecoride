<?php

namespace App\Db;

require BASE_PATH . '/vendor/autoload.php'; // Autoload de composer pour charger la class Client de MongoDB

use Exception;
use MongoDB\Client;

class Mongodb
{
    private $db_name_mongo;
    private $db_user_mongo;
    private $db_password_mongo;
    private $db_port_mongo;
    private $db_host_mongo;
    private static $_instance = null;

    public function __construct()
    {
        // Appel du fichier avec les paramètres de la BDD
        $config = require BASE_PATH . "/config.php";

        $this->db_user_mongo = $config['MONGO_INITDB_ROOT_USERNAME'];
        $this->db_password_mongo = $config['MONGO_INITDB_ROOT_PASSWORD'];
        $this->db_host_mongo = $config['MONGO_HOST'];
        $this->db_port_mongo = $config['MONGO_PORT'];
        $this->db_name_mongo = $config['MONGO_DB_NAME'];
    }


    // SINGLETON pour instancier la class Mongodb une seule fois
    public static function getInstance(): self
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Mongodb;
        }
        return self::$_instance;
    }

    // Fonction pour se connecter à mongodb 
    public function mongoConnect()
    {
        $user = $this->db_user_mongo;
        $password = $this->db_password_mongo;
        $host = $this->db_host_mongo;
        $port = $this->db_port_mongo;
        $dbName = $this->db_name_mongo;

        try {
            // Connection string en LOCAL
            // $connectionPath = "mongodb://".$user.":".$password."@".$host.":".$port."/".$dbName;
            // Connection string en mongoDB Atlas
             $connectionPath = "mongodb+srv://" . $user . ":" . $password . "@" . $host . "/?retryWrites=true&w=majority&appName=" . $dbName;
            // Instance de la classe Client
            $mongo = new Client($connectionPath);
            $db = $mongo->selectDatabase($dbName); // Sélection de la base de données
            // On retourne l'instance de la base de données
            return $db;
        } catch (Exception $e) {
            echo ('Error : ' . $e->getMessage());
            exit;
        }
    }
}
