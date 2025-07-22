<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<head>
    <link rel="stylesheet" href="./Styles/root.css"/>
</head>

<!-- main -->

<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 bg-dark">
                <div class="card-body p-5">
                    <!-- En-tête du formulaire -->
                    <div class="text-center mb-5">
                        <h1 class="display-6 fw-bold text-white mb-2">Vos préférences de conduite</h1>
                        <p class="text-white-50">Personnalisez votre expérience de covoiturage</p>
                    </div>

                    <!-- Première partie du formulaire pour enregistrer les préférences utilisateur -->
                    <form method="post" class="needs-validation <?= ((isset($_POST['prefInscription1']) || isset($_POST['prefInscription2'])) && empty($errors)) ? "hidden" : "" ?>">
                        <div class="preference-section p-4 mb-4 rounded-3 bg-dark-subtle">
                            <!-- Accepte les fumeurs ? -->
                             <div class="d-flex gap-4 align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preference_id" id="smokerYes" value="1"
                                        <?= (isset($_POST['preference_id']) && $_POST['preference_id'] == '1') ? 'checked' : '' ?>>
                                    <label class="form-check-label text-black small-text" for="smokerYes">J'accepte les fumeurs</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preference_id" id="smokerNo" value="3"
                                        <?= (isset($_POST['preference_id']) && $_POST['preference_id'] == '3') ? 'checked' : '' ?>>
                                    <label class="form-check-label text-black small-text" for="smokerNo">Je n'accepte pas les fumeurs</label>
                                </div>
                            </div>

                            <!-- S'il y a une erreur, on l'affiche à l'utilisateur -->
                            <?php if (isset($errors['preferenceIdEmpty'])) { ?>
                                <div class="invalid-tooltip position-static small-text "><?= $errors['preferenceIdEmpty'] ?></div>
                            <?php } ?>
                        </div>
                        <!-- Button pour continuer -->
                        <div class="text-center mt-4">
                            <button class="btn btn-primary w-50 py-3 mt-3 content-text fw-medium"
                                id="btnPreferences"
                                name="prefInscription1" type="submit">Continuer
                                <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                    <!-- Affichage de la 2e partie du formulaire si validé -->
                    <?php
                    if ((isset($_POST['prefInscription1']) || isset($_POST['prefInscription2'])) && empty($errors)) {
                        require_once BASE_PATH.'/Templates/PreferencesUser/preferences-inscription2.php';
                    }
                    ?>                 
                </div>
            </div>
        </div>
    </div>
</section>


<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>