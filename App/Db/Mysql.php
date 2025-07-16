<?php
// Class pour faire la connexion avec la BDD

namespace App\Db;

use Exception;
use PDO;

class Mysql
{
    private $db_name;
    private $db_user;
    private $db_password;
    private $db_port;
    private $db_host;
    private $pdo = null;
    private static $_instance = null;

    public function __construct()
    {
        // Appel du fichier avec les paramètres de la BDD
        $config = require BASE_PATH . "/config.php";

        $this->db_name = $config['DB_NAME'];
        $this->db_user = $config['DB_USER'];
        $this->db_password = $config['DB_PASSWORD'];
        $this->db_port = $config['DB_PORT'];
        $this->db_host = $config['DB_HOST'];
    }

    // SINGLETON pour instancier la class Mysql une seule fois
    public static function getInstance(): self
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Mysql();
        }
        return self::$_instance;
    }

    // Ajout des params à la propipriété pdo et connexion a la BDD via Objet PDO
    public function getPdo()
    {
        try {
            if (is_null($this->pdo)) {
                $dsn = 'mysql:dbname=' . $this->db_name .
                    ';charset=utf8' .
                    ';host=' . $this->db_host .
                    ';port=' . $this->db_port;

                $this->pdo = new PDO($dsn, $this->db_user, $this->db_password);
            }
            return $this->pdo;
        } catch (Exception $e) {
            echo ('Error : ' . $e);
        }
    }
}
