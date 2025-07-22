<?php
// HEADER
use App\Security\Security;

require_once  BASE_PATH . '/Templates/header.php';
?>
<!-- Navbar pour afficher les avis ou les covoiturages signalés -->
<nav class="navbar bg-body-primary employe-navbar content-text fw-bold">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <!-- Avis à valider -->
            <li class="nav-item" id="showAvis">
                <a class="nav-link active d-flex align-items-center" href="#" id="showAvisBtn">
                    <i class="bi bi-star-fill me-2"></i>
                    Avis à valider
                </a>
            </li>
            <!-- Trajets signalés -->
            <li class="nav-item" id="showComments">
                <a class="nav-link d-flex align-items-center" href="#" id="showCommentsBtn">
                    <i class="bi bi-flag-fill me-2"></i>
                    Trajets signalés
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Section avec tous les avis -->
<section class="container mb-5 mt-3" id="avisSection">
    <!-- Titre de la page -->
    <div class="">
        <h2 class="subtitle-text text-center text-black text-capitalize-">Tous les avis</h2>
    </div>
    <!-- La list des avis -->
    <ul class="mt-4 ps-0 avis-list-container">
        <?php foreach ($allAvisAndNotes as $avisAndNote) { ?>
            <!-- Pour transforme l'id de l'avis en string -->
            <?php $avisId = (string)$avisAndNote['_id']; ?>
            <li class="avis-list small-text mb-4">
                <!-- Le pseudo du passager et du chauffeur -->
                <div class="users-name">
                    <!-- Pseudo du passager -->
                    <div class="d-flex gap-2">
                        <p class="fw-bold">Passager: </p>
                        <span class="text-capitalize"><?= $passagerName[$avisId]['pseudo'] ?></span>
                    </div>
                    <!-- Pseudo du chauffeur -->
                    <div class="d-flex gap-2">
                        <p class="fw-bold">Conducteur: </p>
                        <span class="text-capitalize"><?= $driverName[$avisId]['pseudo'] ?></span>
                    </div>
                </div>
                <!-- Le titre de l'avis et la note du chauffeur -->
                <div class="avis-title-note mt-4">
                    <p class="fw-medium"><?= $avisAndNote['titre'] ?></p>
                    <!-- Étoiles pour noter le chauffeur -->
                    <div class="note-stars">
                        <!-- Pour générer les étoiles d'un facon dynamique -->
                        <?php
                        $note = (int)$avisAndNote['note'];
                        for ($i = 1; $i <= 5; $i++) {
                            $active = $i <= $note ? 'active-star' : '';
                            echo "<i class='bi bi-star-fill star $active'></i>";
                        }
                        ?>
                    </div>
                </div>
                <!-- La déscription de l'avis -->
                <div class="avis-description">
                    <p>
                        <?= $avisAndNote['avis'] ?>
                    </p>
                </div>
                <!-- Les boutons d'action : (Valider ou refuser) -->
                <div class="mt-4">
                    <form method="post" class="avis-btn">
                        <!-- Input chaché pour envoyer l'id de l'avis dans le form -->
                        <input type="hidden" name="avis_id" value="<?= $avisAndNote['_id'] ?>">
                        <!-- Refuser -->
                        <button class="btn btn-danger secondary-btn text-white small-text"
                            name="avisRefused"
                            value="0"
                            type="submit">
                            Refuser
                        </button>
                        <!-- Valider -->
                        <button class="btn btn-primary secondary-btn text-white small-text"
                            name="avisValidated"
                            value="1"
                            type="submit"
                            <?= ($avisAndNote['accepte'] == true) ? 'disabled' : '' ?>>
                            <?= ($avisAndNote['accepte'] == true) ? 'Déjà validé' : 'Valider' ?>
                        </button>
                    </form>
                </div>
            </li>
        <?php } ?>
    </ul>
</section>

<!-- Section avec les covoiturages signalés -->
<section class="container mb-5 mt-3 hidden" id="commentsSection">
    <!-- Titre de la page -->
    <div class="">
        <h2 class="subtitle-text text-center text-black text-capitalize-">Tous les commentaires</h2>
    </div>
    <!-- La list des commentaires -->
    <ul class="mt-4 ps-0 comment-list-container">
        <?php foreach ($allComments as $comment) { ?>
            <li class="comment-list small-text mb-4">
                <!-- Le pseudo du passager et du chauffeur -->
                <div class="users-name">
                    <!-- Pseudo du passager -->
                    <div class="d-flex gap-2">
                        <p class="fw-bold">Passager : </p>
                        <span class="text-capitalize"><?= $passagerNameComments[$comment['commentaire_id']]['pseudo'] ?></span>
                    </div>
                    <!-- Pseudo du chauffeur -->
                    <div class="d-flex gap-2">
                        <p class="fw-bold">Conducteur : </p>
                        <span class="text-capitalize"><?= $driverNameComments[$comment['commentaire_id']]['pseudo'] ?></span>
                    </div>
                </div>
                <!-- Le titre du commentaire  -->
                <div class="comment-title mt-4">
                    <p class="fw-medium">Commentaire du passager</p>
                </div>
                <!-- La déscription du commentaire -->
                <div class="comment-description">
                    <p class="ms-2">
                        <?= $comment['commentaire'] ?>
                    </p>
                </div>
                <!-- Le bouton d'action : (Voir le descriptif) -->
                <div class="mt-4 comments-btn">
                    <!-- Button pour ouvir la modal -->
                    <button class="btn btn-warning secondary-btn small-text" data-bs-toggle="modal" data-bs-target="#descriptionModal<?= $comment['commentaire_id'] ?>">
                        Descriptif du trajet
                    </button>
                </div>

                <!-- Modal avec le decriptif du covoiturage -->
                <div class="modal fade covoiturage-description-modal" id="descriptionModal<?= $comment['commentaire_id'] ?>" tabindex="-1" aria-labelledby="descriptionLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="subtitle-text mb-0" id="descriptionLabel">Descriptif du covoiturage</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Les pseudos et mails du passager et du chauffeur -->
                                <div class="d-flex justify-content-around">
                                    <!-- Pseudo et Mail du passager -->
                                    <div class="d-flex flex-column gap-2">
                                        <p class="fw-bold mb-0">Passager :
                                            <span class="text-capitalize fw-normal"><?= $passagerNameComments[$comment['commentaire_id']]['pseudo'] ?>
                                            </span>
                                        </p>
                                        <p class="fw-bold">Mail :
                                            <span class="fw-normal"><?= $comment['passager_mail'] ?>
                                            </span>
                                        </p>
                                    </div>
                                    <!-- Pseudo et Mail du chauffeur -->
                                    <div class="d-flex flex-column gap-2">
                                        <p class="fw-bold mb-0">Conducteur :
                                            <span class="text-capitalize fw-normal"><?= $driverNameComments[$comment['commentaire_id']]['pseudo'] ?>
                                            </span>
                                        </p>
                                        <p class="fw-bold">Mail :
                                            <span class="fw-normal"><?= $comment['driver_mail'] ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <!-- Dscriptif du trajet -->
                                <ul class="covoiturage-description-list">
                                    <li>Numero du covoiturage : <span> <?= $comment['covoiturage_id'] ?> </span></li>
                                    <li>Adresse et date de départ : <span class="text-capitalize"> <?= $comment['adresse_depart'] ?></span> - <span><?= $dateDepartFormatted[$comment['commentaire_id']] ?></span></li>
                                    <li>Adresse et date d'arrivée : <span class="text-capitalize"> <?= $comment['adresse_arrivee'] ?></span> - <span><?= $dateArriveeFormatted[$comment['commentaire_id']] ?></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
</section>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>