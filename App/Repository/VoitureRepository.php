<?php

namespace App\Repository;

use App\Entity\Voiture;
use DateTime;

class VoitureRepository extends Repository
{
    // Fonction pour créer une nouvelle voiture 
    public function createCar(Voiture $voiture, int $user_id)
    {
        $sql = ('INSERT INTO Voiture (modele, couleur, marque, immatriculation, date_premiere_immatriculation, user_id, energie_id)
                        VALUES (:modele, :couleur, :marque, :immatriculation, :date_premiere_immatriculation, :user_id, :energie_id)');
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':modele', $voiture->getModele(), $this->pdo::PARAM_STR);
        $query->bindValue(':couleur', $voiture->getCouleur(), $this->pdo::PARAM_STR);
        $query->bindValue(':marque', $voiture->getMarque(), $this->pdo::PARAM_STR);
        $query->bindValue(':immatriculation', $voiture->getImmatriculation(), $this->pdo::PARAM_STR);
        $query->bindValue(':date_premiere_immatriculation', $voiture->getDatePremiereImmatriculation()->format("Y-m-d"), $this->pdo::PARAM_STR);
        $query->bindValue(':user_id', $user_id, $this->pdo::PARAM_INT);
        $query->bindValue(':energie_id', $voiture->getEnergieId(), $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour trouver une voiture par son # d'immatriculation
    public function findCarByImmatriculation(string $immatriculation)
    {
        $sql = ("SELECT * FROM Voiture WHERE immatriculation = :immatriculation");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':immatriculation', $immatriculation, $this->pdo::PARAM_STR);
        $query->execute();
        $voiture = $query->fetch($this->pdo::FETCH_ASSOC);

        // Si on trouve une voiture, alors, on hydrate la classe de Voiture avec celle trouvée
        if ($voiture) {
            return Voiture::createAndHydrate($voiture);
        } else {
            return false;
        }
    }

    // Fonction pour savoir si l'utilisateur a déjà une ou plusieurs voitures
    public function findCarByUserId(int $userId): bool
    {
        $sql = ("SELECT Voiture.id FROM Voiture WHERE user_id = :user_id");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':user_id', $userId, $this->pdo::PARAM_INT);
        $query->execute();
        $voiture = $query->fetch($this->pdo::FETCH_ASSOC);

        if ($voiture) {
            return true;
        } else {
            return false;
        }
    }

    // Fonction pour récupérer tous les voitures d'un utilisateur
    public function findAllCarsByUserId(int $userId)
    {
        $sql = ("SELECT Voiture.id, Voiture.marque, Voiture.modele, Voiture.immatriculation FROM Voiture WHERE user_id = :user_id");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':user_id', $userId, $this->pdo::PARAM_INT);
        $query->execute();
        $voiture = $query->fetchAll($this->pdo::FETCH_ASSOC);

        if ($voiture) {
            return $voiture;
        } else {
            return false;
        }
    }

}
