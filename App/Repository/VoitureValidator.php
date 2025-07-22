<?php

namespace App\Security;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;

class VoitureValidator
{
    // Fonction qui valide le formulaire pour la création d'une voiture
    public function newCarValidate(Voiture $voitureHydrate): array
    {
        $errors = [];
        $voiture = $voitureHydrate;
        $voitureRepository = new VoitureRepository;
        // Regex pour la validation du bon format de la plaque d'immatriculation
        $regex = "/^[A-Z]{2}-\d{3}-[A-Z]{2}$/";

        // Si le champ est vide
        if (empty($voiture->getImmatriculation())) {
            $errors['immatriculationEmpty'] = "Ce champ est obligatoire";
        } elseif ($voitureRepository->findCarByImmatriculation($voiture->getImmatriculation())){ // Si l'immatriculation de la voiture est dèjà utilisée
            $errors['immatriculationExists'] = "Cette voiture est déjà enregistrée";
        } elseif(!preg_match($regex, $voiture->getImmatriculation())){ // Si l'immatriculation ne respecte pas le format (regex)
            $errors['immatriculationIncorrect'] = "La plaque d'immatriculation doit respecter le format
             'AA-123-AA' avec deux lettres, un tiret, trois chiffres, un autre tiret et deux lettres.";
        }

        // Si le champ est vide
        if (empty($voiture->getDatePremiereImmatriculation())) {
            $errors['dateImmatriculationEmpty'] = "Ce champ est obligatoire";
        }

        // Si le champ est vide
        if (empty($voiture->getModele())) {
            $errors['modeleEmpty'] = "Ce champ est obligatoire";
        }

        // Si le champ est vide
        if (empty($voiture->getMarque())) {
            $errors['marqueEmpty'] = "Ce champ est obligatoire";
        }

        // Si le champ est vide
        if (empty($voiture->getCouleur())) {
            $errors['couleurEmpty'] = "Ce champ est obligatoire";
        }

        // Si le champ est vide
        if($voiture->getEnergieId() == "0"){
            $errors['energieEmpty'] = "Ce champ est obligatoire";
        }



        return $errors;
    }
}
