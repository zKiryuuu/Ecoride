<?php

namespace App\Security;

use App\Entity\PreferenceUser;

class PreferenceUserValidator
{
    // Fonction pour valider le formulaire des préférences utilisateur
    public function newPreferenceValidator(PreferenceUser $preference)
    {
        $errors = [];

        if (empty($preference->getPreferenceId())) {
            $errors['preferenceIdEmpty'] = "Vous devez choisir une réponse";
        }
        return $errors;
    }
}
