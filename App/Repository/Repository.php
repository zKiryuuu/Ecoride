<?php

namespace App\Repository;

use App\Db\Mysql;
use App\Db\Mongodb;
use MongoDB\Database;
use PDO;

class Repository
{
    public PDO $pdo;

    public Database $mongo;

    public function __construct()
    {
        // On appele une instance de la class Mysql pour appeler la base de données
        $mysql = Mysql::getInstance();
        // Et on "passe" l'instance à l'objet PDO pour créer la conexion a la BDD
        $this->pdo = $mysql->getPdo();
        
        // On appelle une instance de la class Mongodb pour appeler la base de données
        $mongo = Mongodb::getInstance();
        // Et on "passe" l'instance à l'objet Database pour créer la conexion a la BDD
        $this->mongo = $mongo->mongoConnect();
    }
}