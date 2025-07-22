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

        $this->db_name = $config['MYSQL_DATABASE'];
        $this->db_user = $config['MYSQL_USER'];
        $this->db_password = $config['DB_PASSMYSQL_PASSWORDWORD'];
        $this->db_port = $config['MYSQL_PORT'];
        $this->db_host = $config['MYSQL_HOST'];
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
    public function getPdo(): PDO
    {
        try {
            $host = $this->db_host;
            $db_name = $this->db_name;
            $db_port = $this->db_port;

            if (is_null($this->pdo)) {
                $dsn = "mysql:host=$host;port=$db_port;dbname=$db_name;charset=utf8";
                return $this->pdo = new PDO($dsn, $this->db_user, $this->db_password);
            }
            return $this->pdo;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
