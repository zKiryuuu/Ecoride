<?php

namespace App\Repository;

use App\Entity\PreferenceUser;
use App\Entity\User;

class PreferenceUserRepository extends Repository
{
    // Fonction pour Insérer une préférence 
    public function createPreference(PreferenceUser $UserPreference, int $user_id)
    {
        $sql = ("INSERT INTO User_Preferences (preference_personnelle, preference_id, user_id) 
                VALUES (:preference_personnelle, :preference_id, :user_id)");
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":preference_personnelle", $UserPreference->getPreferencePersonnelle(), $this->pdo::PARAM_STR);
        $query->bindValue(":preference_id", $UserPreference->getPreferenceId(), $this->pdo::PARAM_INT);
        $query->bindValue(":user_id", $user_id, $this->pdo::PARAM_INT);
        return $query->execute();
    }

    // Fonction pour chercher les péférences du chauffeur
    public function searchPreferencesByDriverId(int $driverId): array
    {
        // On utilise le 'DISTINCT' pour récupérer q'une fois la valeur libelle, si elle est répétée
        $sql = ('SELECT DISTINCT Preference.libelle, User_Preferences.preference_personnelle as personnelle
                FROM User_Preferences
                INNER JOIN User ON User_Preferences.user_id = User.id
                INNER JOIN Preference ON User_Preferences.preference_id = Preference.id
                WHERE User.id = :driverId');
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":driverId", $driverId, $this->pdo::PARAM_INT);
        $query->execute();

        return $query->fetchAll($this->pdo::FETCH_ASSOC);
    }
}
