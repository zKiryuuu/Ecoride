<?php
// HEADER
use App\Security\Security;

require_once  BASE_PATH . '/Templates/header.php';
?>


<section class="container py-5">
    <div class="form-template profile-template">
        <!-- En-tête du profil -->
        <div class="form-header profile-header">
            <div class="profile-image-container">
                <?php
                    $defaultImage = "./Assets/Img_page-vue-covoiturages/driver-default.png";
                    $driverImagePath = (!empty($photoUniqueId)) ? "./Uploads/User/".$photoUniqueId : $defaultImage;
                ?>
                <img src="<?= $driverImagePath ?>" alt="Photo de l'utilisateur" class="profile-image">
            </div>
            <h2><?= $pseudo ?></h2>
            <p class="user-role">
                <?php if (Security::isChauffeur()) : ?>
                    <span class="badge bg-success">Chauffeur</span>
                <?php else : ?>
                    <span class="badge bg-info">Passager</span>
                <?php endif; ?>
            </p>
        </div>

        <!-- Informations principales -->
        <div class="form-section main-info-section">
            <h3 class="section-title"><i class="bi bi-person-fill me-2"></i>Informations personnelles</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value"><?= $mail ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Crédits</span>
                    <span class="info-value credit-badge"><?= $credits ?></span>
                </div>
            </div>
        </div>

        <?php if (Security::isChauffeur()) : ?>
        <!-- Section Préférences -->
        <div class="form-section preferences-section">
            <h3 class="section-title"><i class="bi bi-sliders me-2"></i>Mes préférences</h3>
            <div class="preferences-grid">
                <?php if (in_array("Fumeur", $preferences)) : ?>
                    <div class="preference-item allowed">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>J'accepte les fumeurs</span>
                    </div>
                <?php elseif (in_array("Non_fumeur", $preferences)) : ?>
                    <div class="preference-item not-allowed">
                        <i class="bi bi-x-circle-fill"></i>
                        <span>Je n'accepte pas les fumeurs</span>
                    </div>
                <?php endif; ?>

                <?php if (in_array("Animal", $preferences)) : ?>
                    <div class="preference-item allowed">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>J'accepte les animaux</span>
                    </div>
                <?php elseif (in_array("Non_animal", $preferences)) : ?>
                    <div class="preference-item not-allowed">
                        <i class="bi bi-x-circle-fill"></i>
                        <span>Je n'accepte pas les animaux</span>
                    </div>
                <?php endif; ?>

                <?php foreach ($preferencesPersonnelles as $personnelle) :
                    if (!empty($personnelle)) : ?>
                        <div class="preference-item personal">
                            <i class="bi bi-check-circle-fill"></i>
                            <span><?= ucfirst($personnelle) ?></span>
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>

            <div class="add-preference mt-3">
                <button id="addPreferenceBtn" class="btn btn-outline">
                    <i class="bi bi-plus-circle-fill me-1"></i> Ajouter une préférence
                </button>

                <div id="personalPreference" class="hidden mt-3">
                    <form action="?controller=preferences&action=preferencesInscription" method="post" class="d-flex flex-column gap-2">
                        <textarea name="preference_personnelle" class="form-control" placeholder="Décrivez votre préférence..." required></textarea>
                        <input type="hidden" name="preference_id" value="1">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-filled" name="newPersonalPreference">Ajouter</button>
                            <button type="button" id="cancelPref" class="btn btn-danger">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Section Voitures -->
        <div class="form-section vehicles-section">
            <h3 class="section-title"><i class="bi bi-car-front-fill me-2"></i>Mes voitures</h3>
            <?php if (empty($allCars)) : ?>
                <p class="no-cars-message">Vous n'avez pas encore ajouté de voiture.</p>
            <?php else : ?>
                <div class="vehicles-grid">
                    <?php foreach ($allCars as $car) : ?>
                        <div class="vehicle-card">
                            <div class="vehicle-icon">
                                <i class="bi bi-car-front"></i>
                            </div>
                            <div class="vehicle-info">
                                <h4><?= $car['marque'] ?> <?= $car['modele'] ?></h4>
                                <p><?= $car['immatriculation'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <a href="?controller=voiture&action=carInscription" class="btn btn-outline add-vehicle-btn mt-3">
                <i class="bi bi-plus-circle-fill me-2"></i>Ajouter une voiture
            </a>
        </div>
        <?php endif; ?>

        <!-- Section Administration -->
        <?php if (Security::isEmploye() || Security::isAdmin()) : ?>
        <div class="form-section admin-section">
            <h3 class="section-title"><i class="bi bi-shield-fill me-2"></i>Administration</h3>
            <div class="admin-buttons">
                <?php if (Security::isEmploye()) : ?>
                    <a href="?controller=employe&action=validateAvisAndComments" class="btn btn-warning">
                        <i class="bi bi-person-workspace me-2"></i>Espace employé
                    </a>
                <?php endif; ?>

                <?php if (Security::isAdmin()) : ?>
                    <a href="?controller=admin&action=adminGraphs" class="btn btn-info">
                        <i class="bi bi-graph-up me-2"></i>Statistiques
                    </a>
                    <a href="?controller=admin&action=adminEspace" class="btn btn-primary">
                        <i class="bi bi-people-fill me-2"></i>Gestion des utilisateurs
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Bouton de déconnexion -->
        <div class="d-flex justify-content-center mt-5 mb-5">
            <a href="?controller=auth&action=logOut" class="btn btn-danger logout-btn w-100">
                <i class="bi bi-box-arrow-right me-2"></i>Se déconnecter
            </a>
        </div>

    </div>
</section>



<!-- Script pour gérer le bouton d'annulation du formulaire de préférence -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addPreferenceBtn = document.getElementById('addPreferenceBtn');
    const prefForm = document.getElementById('personalPreference');
    const cancelPrefBtn = document.getElementById('cancelPref');

    if (addPreferenceBtn && prefForm) {
        addPreferenceBtn.addEventListener('click', function() {
            prefForm.classList.remove('hidden');
            addPreferenceBtn.classList.add('hidden');
        });
    }

    if (cancelPrefBtn) {
        cancelPrefBtn.addEventListener('click', function() {
            prefForm.classList.add('hidden');
            addPreferenceBtn.classList.remove('hidden');
        });
    }
});
</script>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>