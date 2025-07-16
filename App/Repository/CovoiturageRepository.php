<?php

namespace App\Repository;

use App\Entity\Covoiturage;

class CovoiturageRepository extends Repository
{

    // Fonction pour créer un nouveau covoiturage
    public function createCovoiturage(Covoiturage $covoiturage)
    {
        $sql = ("INSERT INTO Covoiturage 
                       (date_heure_depart, date_heure_arrivee, adresse_depart, adresse_arrivee, nb_place_disponible, prix, voiture_id, statut_id) 
                VALUES (:date_heure_depart,:date_heure_arrivee, :adresse_depart, :adresse_arrivee, :nb_place_disponible, :prix, :voiture_id, :statut_id)");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":date_heure_depart", $covoiturage->getDateHeureDepart()->format("Y-m-d H:i"), $this->pdo::PARAM_STR);
        $query->bindValue(":date_heure_arrivee", $covoiturage->getDateHeureArrivee()->format("Y-m-d H:i"), $this->pdo::PARAM_STR);
        $query->bindValue(":adresse_depart", $covoiturage->getAdresseDepart(), $this->pdo::PARAM_STR);
        $query->bindValue(":adresse_arrivee", $covoiturage->getAdresseArrivee(), $this->pdo::PARAM_STR);
        $query->bindValue(":nb_place_disponible", $covoiturage->getNbPlaceDisponible(), $this->pdo::PARAM_INT);
        $query->bindValue(":prix", $covoiturage->getPrix(), $this->pdo::PARAM_INT);
        $query->bindValue(":voiture_id", $covoiturage->getVoitureId(), $this->pdo::PARAM_INT);
        $query->bindValue(":statut_id", $covoiturage->getStatutId(), $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour chercher tous les covoiturages
    public function getAllCovoiturages(): array
    {
        $sql = ("SELECT Covoiturage.*, User.id AS driver_id FROM Covoiturage
                        INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                        INNER JOIN User ON Voiture.user_id = User.id
                        ORDER BY date_heure_depart ASC");
        $query = $this->pdo->prepare($sql);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour checher des covoiturages
    public function searchCovoiturageByDateAndAdresse(string $adresseDepart, string $adresseArrivee, ?string $dateDepart = null): array
    {
        $sql = ("SELECT Covoiturage.*, User.id AS driver_id FROM Covoiturage
                INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                INNER JOIN User ON Voiture.user_id = User.id
                WHERE adresse_depart LIKE :adresseDepart AND
                adresse_arrivee LIKE :adresseArrivee
                ");

        // Si on passe la date de départ, alors on l'ajout au query sql
        (!empty($dateDepart)) ? $sql .= " AND date_heure_depart LIKE :dateDepart" : null;

        $query = $this->pdo->prepare($sql);

        $query->bindValue(":adresseDepart", "%$adresseDepart%", $this->pdo::PARAM_STR);
        $query->bindValue(":adresseArrivee", "%$adresseArrivee%", $this->pdo::PARAM_STR);
        // Si on passe la date de départ, alors on fait le bindValue avec la donée passée 
        (!empty($dateDepart)) ? $query->bindValue(":dateDepart", "%$dateDepart%", $this->pdo::PARAM_STR) : null;

        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour checher tous les détails des covoiturages par le covoiturage ID
    public function searchCovoiturageDetailsById(int $CovoiturageId): array
    {
        $sql = ("SELECT Covoiturage.*, Covoiturage.id as covoiturage_id,
                User.pseudo, User.photo_uniqId, User.nb_credits, User.id as user_id,
                Voiture.marque, Voiture.modele, 
                Energie.id as energie_id, Energie.libelle as energie
                FROM Covoiturage
                INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                INNER JOIN User ON Voiture.user_id = User.id
                INNER JOIN Energie ON Voiture.energie_id = Energie.id
                WHERE Covoiturage.id = :CovoiturageId;
                ");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":CovoiturageId", $CovoiturageId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour checher les détails des covoiturages par l'user ID
    public function searchCovoiturageDetailsByUserId(int $userId): array
    {
        $sql = ("SELECT Covoiturage.id, Covoiturage.date_heure_depart, Covoiturage.date_heure_arrivee, 
                Covoiturage.adresse_depart, Covoiturage.adresse_arrivee, Covoiturage.prix, Covoiturage.statut_id,
                User.pseudo, User.photo_uniqId
                FROM Covoiturage
                INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                INNER JOIN User ON Voiture.user_id = User.id
                WHERE User.id = :userId;
                ");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":userId", $userId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour checher uniquement les covoiturages écologiques
    public function filterSearchCovoiturage(
        string $dateDepart,
        string $adresseDepart,
        string $adresseArrivee,
        ?int $energiId = null,
        ?int $maxPrice = null,
        ?int $maxDuration = null,
    ): array {
        $sql = ("SELECT Covoiturage.*, User.id as driver_id
                FROM Covoiturage
                INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                INNER JOIN Energie ON Voiture.energie_id = Energie.id
                INNER JOIN User ON Voiture.user_id = User.id
                WHERE date_heure_depart LIKE :dateDepart AND 
                adresse_depart LIKE :adresseDepart AND
                adresse_arrivee LIKE :adresseArrivee
                ");

        // Si on passe des paramètres des filtres, on les ajout au query sql
        (!empty($energiId)) ? $sql .= " AND  Energie.id = :energiId" : null;
        (!empty($maxPrice)) ? $sql .= " AND  prix <= :price" : null;
        (!empty($maxDuration)) ? $sql .= " AND  TIMESTAMPDIFF(HOUR, date_heure_depart, date_heure_arrivee) <= :maxDuration" : null;

        $query = $this->pdo->prepare($sql);
        $query->bindValue(":dateDepart", "%$dateDepart%", $this->pdo::PARAM_STR);
        $query->bindValue(":adresseDepart", "%$adresseDepart%", $this->pdo::PARAM_STR);
        $query->bindValue(":adresseArrivee", "%$adresseArrivee%", $this->pdo::PARAM_STR);
        // Si on passe des paramètres des filtres, on fait les bindValue
        (!empty($energiId)) ? $query->bindValue(":energiId", $energiId, $this->pdo::PARAM_INT) : null;
        (!empty($maxPrice)) ? $query->bindValue(":price", $maxPrice, $this->pdo::PARAM_INT) : null;
        (!empty($maxDuration)) ? $query->bindValue(":maxDuration", $maxDuration, $this->pdo::PARAM_INT) : null;
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour enregistrer la participation à un covoiturage
    public function participateToCovoiturage(int $userId, int $covoiturageId)
    {
        $sql = "INSERT INTO User_Covoiturages (user_id, covoiturage_id)
                VALUES (:userId, :covoiturageId)";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":userId", $userId, $this->pdo::PARAM_INT);
        $query->bindValue(":covoiturageId", $covoiturageId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour chercher les covoiturages auxquels l'utilisateur participe
    public function searchCovoiturageParticipateByUserId(int $userId): array
    {
        $sql = "SELECT Covoiturage.id, Covoiturage.date_heure_depart, Covoiturage.date_heure_arrivee,
                Covoiturage.adresse_depart, Covoiturage.adresse_arrivee, Covoiturage.prix
                FROM User_Covoiturages 
                INNER JOIN Covoiturage ON User_Covoiturages.covoiturage_id = Covoiturage.id 
                WHERE user_id = :userId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":userId", $userId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    /* Fonction pour enlever les credits du covoiturage, 
    quand l'user participe à un covoiturage, ou quand l'user quitte le covoiturage
    */
    public function updateUserCredits(int $covoituragePrice, int $userId, bool $addition): bool
    {
        // Si l'addition est 1 (true), alors on ajoute les credits, sinon on les enleve
        $sql = "UPDATE User 
                SET nb_credits = 
                CASE
                    WHEN :addition = 1 THEN nb_credits + :covoituragePrice
                    WHEN nb_credits > 0 THEN nb_credits - :covoituragePrice
                    ELSE false
                END
                WHERE id = :userId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":addition", $addition, $this->pdo::PARAM_BOOL);
        $query->bindValue(":covoituragePrice", $covoituragePrice, $this->pdo::PARAM_INT);
        $query->bindValue(":userId", $userId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    /* Fonction pour mettre à jour les nombres de places disponible du covoiturage 
    quand l'user participe à un covoiturage, ou quand l'user quitte le covoiturage
    */
    public function updatePlacesDisponibles(int $covoiturageId, bool $addition)
    {
        // Si l'addition est 1 (true), alors on ajoute une place, sinon on enleve une place
        $sql = "UPDATE Covoiturage
            SET nb_place_disponible = 
            CASE
                WHEN :addition = 1 THEN nb_place_disponible + 1
                WHEN nb_place_disponible > 0 THEN nb_place_disponible - 1
                ELSE false
            END
            WHERE id = :covoiturageId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":addition", $addition, $this->pdo::PARAM_BOOL);
        $query->bindValue(":covoiturageId", $covoiturageId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour enlever l'user du covoiturage, quand l'user quitte le covoiturage
    public function quitCovoiturageAsPassager(int $userId, int $covoiturageId)
    {
        $sql = "DELETE FROM User_Covoiturages
                WHERE user_id = :userId AND covoiturage_id = :covoiturageId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":userId", $userId, $this->pdo::PARAM_INT);
        $query->bindValue(":covoiturageId", $covoiturageId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour enlever le covoiturage, quand l'user chauffeur quitte le covoiturage
    public function deleteCovoiturageAsDriver(int $covoiturageId)
    {
        $sql = "DELETE FROM Covoiturage
                WHERE id = :covoiturageId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":covoiturageId", $covoiturageId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour chercher les participants d'un covoiturage par le covoiturage ID, et le pseudo du chauffeur
    public function searchCovoiturageParticipantsByCovoiturageId(int $covoiturageId): array
    {
        $sql = "SELECT User_Covoiturages.user_id, passager.mail as passager_mail, passager.pseudo as passager_pseudo, passager.id as passager_id,
                       driver.pseudo as driver_pseudo, driver.id as driver_id
                FROM User_Covoiturages
                INNER JOIN User as passager ON User_Covoiturages.user_id = passager.id
                INNER JOIN Covoiturage ON User_Covoiturages.covoiturage_id = Covoiturage.id
                INNER JOIN Voiture ON Covoiturage.voiture_id = Voiture.id
                INNER JOIN User as driver ON Voiture.user_id = driver.id
                WHERE covoiturage_id = :covoiturageId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":covoiturageId", $covoiturageId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour savoir si le l'utilisateur participe déjà à un covoiturage
    public function isUserParticipant(int $userId, int $covoiturageId): bool
    {
        $sql = "SELECT id FROM User_Covoiturages
                WHERE user_id = :userId AND covoiturage_id = :covoiturageId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":userId", $userId, $this->pdo::PARAM_INT);
        $query->bindValue(":covoiturageId", $covoiturageId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetch() ? true : false; // Si le fetch renvoie une ligne, alors l'utilisateur participe déjà au covoiturage
    }

    // Fonction pour changer le statut d'un covoiturage
    public function updateCovoiturageStatut(int $covoiturageId, int $statutId): bool
    {
        $sql = "UPDATE Covoiturage 
                SET statut_id = :statutId
                WHERE Covoiturage.id = :covoiturageId;";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":statutId", $statutId, $this->pdo::PARAM_INT);
        $query->bindValue(":covoiturageId", $covoiturageId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour changer le statut de la participation d'un passager dans un covoiturage
    public function updateUserCovoiturageStatut(int $passgerId, int $covoiturageId, int $statutId): bool
    {
        $sql = "UPDATE User_Covoiturages 
                SET statut_id = :statutId
                WHERE user_id = :passgerId AND covoiturage_id = :covoiturageId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":statutId", $statutId, $this->pdo::PARAM_INT);
        $query->bindValue(":passgerId", $passgerId, $this->pdo::PARAM_INT);
        $query->bindValue(":covoiturageId", $covoiturageId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour trouver les dates de tous les covoiturages,
    // les nombres de covoiturages par jour
    // et la gain journalier de la plateforme selon la quantité des participations dasn les covoiturages
    public function getPlatformCovoituragesAndGainPerDate(): array
    {
        $sql = "SELECT 
                DATE_FORMAT(c.date_heure_depart, '%d-%m-%Y') AS jour,
                COUNT(DISTINCT c.id) AS nb_trajets,
                COUNT(uc.id) * 2 AS gain
                FROM Covoiturage c
                LEFT JOIN User_Covoiturages uc ON uc.covoiturage_id = c.id
                GROUP BY jour
                ORDER BY STR_TO_DATE(jour, '%d-%m-%Y') ASC;";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }

    // Fonction pour mettre à jour les crédits du chauffeur après la validation du passager
    public function updateDriverCredits(int $covoituragePrice, int $driverId): bool
    {
        $sql = "UPDATE User 
                SET nb_credits = nb_credits + :covoituragePrice
                WHERE id = :driverId;";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":covoituragePrice", $covoituragePrice, $this->pdo::PARAM_STR);
        $query->bindValue(":driverId", $driverId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour ajouter un commentaire au covoiturage, quand le passager indique qu'il s'est mal passé 
    public function addCommentaireToCovoiturage(string $commentaire, int $userCovoiturageId): bool
    {
        $sql = "INSERT INTO Commentaire (commentaire, user_covoiturage_id)
                VALUES (:commentaire, :userCovoiturageId);";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":commentaire", $commentaire, $this->pdo::PARAM_STR);
        $query->bindValue(":userCovoiturageId", $userCovoiturageId, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour chercher l'id de la participation d'un passager dans un covoiturage. (Table : User_Covoiturages)
    public function searchUserCovoiturageId(int $userId, int $covoiturageId): array
    {
        $sql = "SELECT id FROM User_Covoiturages
                WHERE user_id = :userId AND covoiturage_id = :covoiturageId";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":userId", $userId, $this->pdo::PARAM_INT);
        $query->bindValue(":covoiturageId", $covoiturageId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetch($this->pdo::FETCH_ASSOC);
    }

    // SECTION MONGODB
    public function getOne(string $name)
    {
        $collection = $this->mongo->test;
        $data = $collection->findOne(['nombre' => $name]);
        return $data;
    }
    public function insertOne(string $name, int $age)
    {
        $collection = $this->mongo->test;
        $data = $collection->insertOne(['nombre' => $name, 'edad' => $age]);
        return $data;
    }

    public function insertDates(string $date, int $quantity)
    {
        $collection = $this->mongo->covoiturage_for_day;
        $insert = $collection->insertOne(['date' => $date, 'quantity' => $quantity]);
        return $insert;
    }
}
