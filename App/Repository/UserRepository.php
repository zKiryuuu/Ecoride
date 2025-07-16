<?php

namespace App\Repository;

use App\Entity\User;
use MongoDB\Operation\Aggregate;

class UserRepository extends Repository
{
    // Fonction pour créer un nouveau utilisateur
    public function createUser(User $user)
    {
        $sql = ("INSERT INTO User (pseudo, mail, password, role_id) VALUES (:pseudo,:mail,:mdp, :role_id)");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":pseudo", $user->getPseudo(), $this->pdo::PARAM_STR);
        $query->bindValue(":mail", $user->getMail(), $this->pdo::PARAM_STR);
        $query->bindValue(":mdp", $user->getPassword(), $this->pdo::PARAM_STR);
        $query->bindValue(":role_id", $user->getRoleId(), $this->pdo::PARAM_STR);
        return $query->execute();
    }

    // Fonction pour créer un nouveau utilisateur chauffeur, pour ajouter la photo
    public function createDriverUser(User $user)
    {
        $sql = ("INSERT INTO User (pseudo, mail, password, photo, photo_uniqId, role_id) 
        VALUES (:pseudo, :mail, :mdp, :photo, :photo_uniqId, :role_id)");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":pseudo", $user->getPseudo(), $this->pdo::PARAM_STR);
        $query->bindValue(":mail", $user->getMail(), $this->pdo::PARAM_STR);
        $query->bindValue(":mdp", $user->getPassword(), $this->pdo::PARAM_STR);
        $query->bindValue(":photo", $user->getPhoto(), $this->pdo::PARAM_STR);
        $query->bindValue(":photo_uniqId", $user->getPhotoUniqId(), $this->pdo::PARAM_STR);
        $query->bindValue(":role_id", $user->getRoleId(), $this->pdo::PARAM_STR);
        return $query->execute();
    }

    // Fonction pour trouver un utilisateur par son mail
    public function findOneByMail(string $mail)
    {
        $sql = ("SELECT * FROM User WHERE mail = :mail");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':mail', $mail, $this->pdo::PARAM_STR);
        $query->execute();
        $user = $query->fetch($this->pdo::FETCH_ASSOC);

        // Si on trouve un utilisateur, alors, on hydrate la classe de l'utilisateur avec celui trouvé
        if ($user) {
            return User::createAndHydrate($user);
        } else {
            return false;
        }
    }

    // Fonction pour trouver le nom du role selon l'id donné
    public function findRoleName(string $role_id)
    {
        $sql = ("SELECT libelle FROM Role WHERE id = :role_id");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':role_id', $role_id, $this->pdo::PARAM_STR);
        $roleName = $query->execute();
        $roleName = $query->fetch($this->pdo::FETCH_ASSOC);

        if ($roleName) {
            return $roleName['libelle'];
        } else {
            return false;
        }
    }

    // Fonction pour trouver un utilisateur par son id
    public function findUserById(int $userId): array
    {
        $sql = ("SELECT pseudo FROM User WHERE id = :userId");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':userId', $userId, $this->pdo::PARAM_INT);
        $query->execute();
        return $query->fetch($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour trouver tous les utilisateurs
    public function findAllUsers(): array
    {
        $sql = ("SELECT User.id, pseudo, mail, Role.libelle as user_role, nb_credits, active
                FROM User
                INNER JOIN Role ON User.role_id = Role.id;");
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour créer un nouveau utilisateur
    public function createEmployeAccount(User $user)
    {
        $sql = ("INSERT INTO User (pseudo, mail, password, role_id) VALUES (:pseudo,:mail,:mdp, 4)");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":pseudo", $user->getPseudo(), $this->pdo::PARAM_STR);
        $query->bindValue(":mail", $user->getMail(), $this->pdo::PARAM_STR);
        $query->bindValue(":mdp", $user->getPassword(), $this->pdo::PARAM_STR);
        return $query->execute();
    }

    // Fonction pour suspendre un utilisateur
    public function suspendUser(int $userId): bool
    {
        $sql = ("UPDATE User SET active = 0 WHERE id = :userId");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':userId', $userId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // MONGODB SECTION

    // Fonction pour calculer la note d'un conducteur
    public function findDriverNote(int $driverId)
    {
        $collection = $this->mongo->Avis;
        $data = $collection->aggregate([
            [
                '$match' => ['user_id_cible' => $driverId] // Pour associer l'id passé
            ],
            [ // Pour aggrouper par id et calculer la note moyenne selon la note donnée par les passagers
                '$group' =>
                [
                    '_id' => '$user_id_cible',
                    'note' => ['$avg' => '$note']
                ]
            ],
            [ // Avec le project je peux arrondir la note, afin d'avoir q'une seule chiffre après la virgule
                '$project' => [
                    '_id' => 1, // on laisse 1 pour afficher l'id
                    'note' => [
                        '$round' => ['$note', 1] // Redondear a 1 decimal
                    ]
                ]
            ]
        ]);

        // Pour convertir l'objet mongo dans un array php
        $result = iterator_to_array($data);
        // Si on a des résultats, on les rendre, sinon, on laisse la note à null
        return $result[0] ?? ['note' => null];
    }
}
