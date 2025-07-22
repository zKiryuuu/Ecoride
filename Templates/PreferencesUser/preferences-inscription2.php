<!-- Deuxième partie du formulaire pour enregistrer les préferences -->
<form method="post" class="d-flex flex-column chauffeur" id="preferencesForm">
    <div class="mt-1 d-flex gap-4 preferences-form content-text">
        <!-- Accepte des animaux ? -->
        <div class=" gap-2 align-items-center">
            <label for="animalCheck" class="form-check-label content-text">J'accepte les animaux: </label>
            <input type="radio" class="form-check-input" name="preference_id" id="animalCheck" value="2"> <span class="text-white small-text">Oui</span>
            <input type="radio" class="form-check-input" name="preference_id" id="animalCheck" value="4"> <span class="text-white small-text">Non</span>
        </div>
        <!-- S'il y a une erreur, on l'affiche à l'utilisateur -->
        <?php if (isset($errors2['preferenceIdEmpty'])) { ?>
            <div class="invalid-tooltip position-static small-text "><?= $errors2['preferenceIdEmpty'] ?></div>
        <?php } ?>
        <!-- Ajouter des préférences personnelles -->
        <div class="d-flex flex-column gap-2">
            <label for="preference_personnelle" class="content-text" class="form-label">Ajoutez une nouvelle préférence: </label>
            <input type="text" name="preference_personnelle" id="preference_personnelle" class="form-control content-text">
        </div>
    </div>
    <!-- Button pour finaliser -->
    <div class="text-center mt-4">
        <button class="btn btn-primary text-dark w-50 py-3 mt-3 content-text fw-medium"
            name="prefInscription2" type="submit">Finaliser</button>
    </div>
</form>