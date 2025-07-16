<?php

namespace App\Entity;

use App\Tools\StringTools;

class Entity
{
    // Fonction pour instancier un objet de la classe de l'enfant et le hydrater avec les données passées
    public static function createAndHydrate(array $data): static
    {
        // Ici static fait référence à la classe de l'enfant, alors que self fait référence à la classe courante
        $entity = new static();
        $entity->hydrate($data);
        return $entity;
    }

    // Function pour "hydrater" les entités avec les données passées
    public function hydrate(array $data)
    {
        // S'il existe des données
        if (count($data) > 0) {
            // On parcourt le tableau de données
            foreach ($data as $key => $value) {
                // Pour chaque donnée, on appel le setter et on convertit le text on PascalCase
                $methodName = 'set' . StringTools::toPascalCase($key);
                // Si le method set existe, alors on passe le set avec le value correspondant
                if (method_exists($this, $methodName)) {
                    // Pour les données de types Datetime
                    if ($key == 'date_premiere_immatriculation' || $key == 'date_heure_depart' || $key == 'date_heure_arrivee') {
                        // Si l'utlisateur ne sélectionne pas une date, 
                        // alors, la date est null, 
                        // sinon, on crée un objet DateTime avec la value passée
                        if (empty($value)) {
                            $value = null;
                        } else {
                            $value = new \DateTime($value);
                        }
                    }
                    $this->{$methodName}($value);
                }
            }
        }
    }
}
