<?php
// HEADER
use App\Security\Security;

require_once  BASE_PATH . '/Templates/header.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../public/Styles/new.css"/>
    
</head>

<!-- Main -->
<!-- Section avec le hero, et le bouton pour créer un nouveau covoiturage si l'user est chauffer -->
<section class="text-center mes-covoiturages-hero">
    <!-- Contient le titre et le bouton -->
    <div class="container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <!-- titre -->
                <h1 class="headline-text">Mes covoiturages</h1>
                <!-- Si l'utilsateur est connecté et a le rôle du chauffeur, alors, 
                on affiche le bouton vers la page pour saisir un nouveau covoiturage -->
                <?php if (Security::isLogged() && Security::isChauffeur()) { ?>
                    <a href="?controller=covoiturages&action=createCovoiturage"
                        class="btn btn-filled mt-3 content-text fw-medium">Créer un nouveau covoiturage</a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>



<!-- Section avec la liste des covoiturages auxquels l'user participe, et auxquels l'user conduit -->
<section class="container mt-4 mb-5">
    <!-- Les covoiturages auxquels l'user participe -->
    <div class="accordion mb-3" id="preferenceAccordion">
        <div class="accordion-item">
            <!-- Header -->
            <h2 class="accordion-header">
                <button class="accordion-button collapsed content-text fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseParticipe" aria-expanded="false" aria-controls="collapseParticipe">
                    Mes covoiturages en tant que passager
                </button>
            </h2>
            <!-- body -->
            <div id="collapseParticipe" class="accordion-collapse collapse" data-bs-parent="#preferenceAccordion">
                <div class="accordion-body">
                    <?php if ($covoiturageaAsPassager) { ?>
                        <!-- Liste avec les covoiturages -->
                        <ul>
                            <?php foreach ($covoiturageaAsPassager as $covoiturage) { ?>
                                <li class="content-text">
                                    <!-- Le jour et le mois du covoiturage -->
                                    <div class="fw-medium covoiturage-day-month">
                                        <p class="mb-0 text-center"><?= $dayName[$covoiturage['id']] . ", " . $dayNumber[$covoiturage['id']] . " " . $monthName[$covoiturage['id']] ?></p>
                                    </div>
                                    <!-- Les heures et adresses de départ et d'arrivée-->
                                    <div class="covoiturage-info-list">
                                        <!-- Les heures -->
                                        <div class="covoiturage-date-time">
                                            <p class="fw-semibold">Départ</p>
                                            <p><?= $covoiturage['adresse_depart'] ?></p>
                                            <p><?= substr($covoiturage['date_heure_depart'], 11, 5) ?></p>
                                        </div>
                                        <i class="bi bi-arrow-right"></i>
                                        <!-- Les adresses -->
                                        <div class="covoiturage-date-time">
                                            <p class="fw-semibold">Arrivée</p>
                                            <p><?= $covoiturage['adresse_arrivee'] ?></p>
                                            <p><?= substr($covoiturage['date_heure_arrivee'], 11, 5) ?></p>
                                        </div>
                                    </div>
                                    <!-- Bouton pour voir plus en détail le covoiturage et pour le quitter -->
                                    <div class="covoiturage-btn-div d-flex justify-content-evenly">
                                        <!-- Bouton pour ouvrir la modale de confirmation -->
                                        <button class="btn btn-danger secondary-btn text-light" data-bs-toggle="modal" data-bs-target="#leaveCovoiturageModal<?= $covoiturage['id'] ?>">
                                            Quitter
                                        </button>
                                        <!-- Modal pour confirmer l'annulation du covoiturage -->
                                        <!-- Ajout de l'id du covoiturage à l'id de la modal, afin d'eviter des id en double, car la modal est dans un boucle -->
                                        <div class="modal fade" id="leaveCovoiturageModal<?= $covoiturage['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="leaveCovoiturageModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <!-- Le contenu de la modal -->
                                                <div class="modal-content">
                                                    <!-- Bouton pour fermer la modal -->
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    <!-- Formulaire pour confirmer l'annulation du covoiturage  -->
                                                    <form method="post" class="w-100 d-flex align-items-center flex-column gap-4 p-5 mb-0 bg-light form">
                                                        <!-- input invisible pour envoyer l'id du covoiturage, de l'user dans le formulaire et le prix-->
                                                        <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">
                                                        <input type="hidden" name="covoiturage_id" value="<?= $covoiturage['id'] ?>">
                                                        <input type="hidden" name="covoiturage_price" value="<?= $covoiturage['prix'] ?>">
                                                        <label class="content-text text-center fw-medium">Voulez-vous vraiment quitter ce covoiturage? <br>Cette action est définitive.</label>
                                                        <!-- Bouton pour confirmer -->
                                                        <div class="d-flex gap-3 justify-content-center">
                                                            <input type="submit" class="btn btn-danger shadow-section text-white content-text secondary-btn" value="Confirmer" name="quitCovoiturageAsPassager">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Bouton pour voir les détails du covoiturage -->
                                        <a href="?controller=covoiturages&action=showOne&id=<?= $covoiturageEncryptId[$covoiturage['id']] ?>" class="btn btn-warning secondary-btn">Détail</a>
                                    </div>
                                </li>

                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="mb-0 fw-medium">Aucun covoiturage pour le moment</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Si l'utilisateur est chauffeur, alors on affiche les covoiturages auxquels il conduit -->
    <?php if (Security::isChauffeur()) { ?>
        <!-- Les covoiturages auxquels l'user conduit -->
        <div class="accordion" id="carAccordion">
            <div class="accordion-item">
                <!-- Header -->
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed content-text fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDrive" aria-expanded="false" aria-controls="collapseDrive">
                        Mes covoiturages en tant que chauffeur
                    </button>
                </h2>
                <!-- Body -->
                <div id="collapseDrive" class="accordion-collapse collapse" data-bs-parent="#carAccordion">
                    <div class="accordion-body">
                        <!-- Liste avec les covoiturages -->
                         <?php if (!empty($covoituragesAsDriver)) { ?>
                            <ul>
                                <?php foreach ($covoituragesAsDriver as $covoiturage) { ?>
                                    <li class="content-text">
                                        <!-- Le jour et le mois du covoiturage -->
                                        <div class="fw-medium covoiturage-day-month">
                                        <p class="mb-0 text-center"><?= $dayName[$covoiturage['id']] . ", " . $dayNumber[$covoiturage['id']] . " " . $monthName[$covoiturage['id']] ?></p>
                                        </div>
                                        <!-- Les heures et adresses de départ et d'arrivée-->
                                        <div class="covoiturage-info-list">
                                        <!-- Les heures -->
                                        <div class="covoiturage-date-time">
                                            <p class="fw-semibold">Départ</p>
                                            <p><?= $covoiturage['adresse_depart'] ?></p>
                                            <p><?= substr($covoiturage['date_heure_depart'], 11, 5) ?></p>
                                        </div>
                                        <i class="bi bi-arrow-right"></i>
                                        <!-- Les adresses -->
                                        <div class="covoiturage-date-time">
                                            <p class="fw-semibold">Arrivée</p>
                                            <p><?= $covoiturage['adresse_arrivee'] ?></p>
                                            <p><?= substr($covoiturage['date_heure_arrivee'], 11, 5) ?></p>
                                        </div>
                                        </div>
                                        <!-- Tous les boutons d'action du covoiturage -->
                                        <div class="covoiturage-btn-div d-flex justify-content-evenly">
                                        <!-- Bouton pour pour ouvrir la modal de confirmation -->
                                        <button class="btn btn-danger secondary-btn text-light" data-bs-toggle="modal" data-bs-target="#deleteCovoiturageModal<?= $covoiturage['id'] ?>">
                                            Supprimer
                                        </button>
                                        <!-- Modal pour confirmer l'annulation du covoiturage -->
                                        <!-- Ajout de l'id du covoiturage à l'id de la modal, afin d'eviter des id en double, car la modal est dans un boucle -->
                                        <div class="modal fade" id="deleteCovoiturageModal<?= $covoiturage['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteCovoiturageModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <!-- Le contenu de la modal -->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h1 class="modal-title fs-5">Gestion des covoiturages</h1>
                                                      <!-- Bouton pour fermer la modal -->
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <!-- Formulaire pour confirmer l'annulation du covoiturage  -->
                                                        <form method="post" class="w-100 d-flex align-items-center flex-column gap-4 p-5 mb-0 form">
                                                            <!-- input invisible pour envoyer l'id et le prix du covoiturage dans le formulaire-->
                                                            <input type="hidden" name="covoiturage_id" value="<?= $covoiturage['id'] ?>">
                                                            <input type="hidden" name="covoiturage_price" value="<?= $covoiturage['prix'] ?>">
                                                            <label class="content-text text-center fw-medium">Voulez-vous vraiment annuler ce covoiturage?<br>Tous les participants seront informés de l’annulation.</label>
                                                            <!-- Bouton pour confirmer -->
                                                            <div class="d-flex gap-3 justify-content-center">
                                                                <input type="submit" class="btn btn-danger shadow-section text-white content-text secondary-btn" value="Confirmer" name="deleteCovoiturageAsDriver">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <!-- Bouton pour voir les détails du covoiturage -->
                                        <a href="?controller=covoiturages&action=showOne&id=<?= $covoiturageEncryptId[$covoiturage['id']] ?>"
                                            class="btn btn-warning secondary-btn text-dark">Détail</a>
                                        <!-- Boutons pour démarrer, arrivé à destination et clôturé le covoiturage -->
                                        <!-- Les statuts d'un covoiturage : 
                                         - 1 : Crée - 2 : Démarré - 3 : Arrivé - 4 : Validé 
                                        -->
                                        <?php if ($covoiturage['statut_id'] == 1) { ?>
                                            <button id="startBtn<?= $covoiturage['id'] ?>"
                                                class="btn btn-primary secondary-btn text-white"
                                                onclick="startCovoiturage(<?= $covoiturage['id'] ?>)">
                                                Démarrer
                                            </button>
                                        <?php } else { ?>
                                            <button id="startBtn<?= $covoiturage['id'] ?>"
                                                class="btn btn-primary secondary-btn text-white hidden">
                                                Démarrer
                                            </button>
                                        <?php } ?>
                                        <?php if ($covoiturage['statut_id'] == 2) { ?>
                                            <button id="arriveBtn<?= $covoiturage['id'] ?>"
                                                class="btn btn-primary secondary-btn text-white"
                                                onclick="arriveCovoiturage(<?= $covoiturage['id'] ?>)">
                                                Arrivée à destination
                                            </button>
                                        <?php } else { ?>
                                            <button id="arriveBtn<?= $covoiturage['id'] ?>"
                                                class="btn btn-primary secondary-btn text-white hidden"
                                                onclick="arriveCovoiturage(<?= $covoiturage['id'] ?>)">
                                                Arrivée à destination
                                            </button>
                                        <?php } ?>
                                        <?php if ($covoiturage['statut_id'] == 3 || $covoiturage['statut_id'] == 4) { ?>
                                            <button id="finishBtn<?= $covoiturage['id'] ?>"
                                                class="btn btn-dark secondary-btn text-white">
                                                Clôturé
                                            </button>
                                        <?php } else { ?>
                                            <button id="finishBtn<?= $covoiturage['id'] ?>"
                                                class="btn btn-dark secondary-btn text-white hidden">
                                                Clôturé
                                            </button>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="mb-0 fw-medium">Aucun covoiturage pour le moment</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</section>


<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>