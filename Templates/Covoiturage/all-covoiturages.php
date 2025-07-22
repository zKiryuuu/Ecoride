<?php
// HEADER
use App\Security\Security;
require_once  BASE_PATH . '/Templates/header.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/Styles/new.css"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<section class="covoiturages container py-4">
  <div class="row">
    <!-- Filtres (à gauche) -->
    <aside class="col-lg-4 mb-4">
      <div class="filter card shadow-sm p-3 rounded">
        <div class="filter-header d-flex align-items-center justify-content-between mb-3">
          <h3 class="subtitle-text mb-0">Filtrer</h3>
          <i class="bi bi-filter"></i>
        </div>
        <form method="post" class="filter-body">
          <!-- Voyage Écologique -->
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-tree me-1"></i> Voyage Écologique</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="ecologique"<?= (!empty($_POST['ecologique'])) ? "checked" : "" ?> />
            </div>
          </div>
          <!-- Prix maximum -->
          <div class="mb-3">
            <label for="price" class="form-label"><i class="bi bi-c-circle me-1"></i> Prix maximum</label>
            <input type="number" class="form-control" name="maxPrice" id="price" value="<?= $maxPrice ?>" />
          </div>
          <!-- Durée maximum -->
          <div class="mb-3">
            <label for="duration" class="form-label"><i class="bi bi-clock me-1"></i> Durée maximale</label>
            <input type="number" class="form-control" name="maxDuration" id="duration" value="<?= $maxDuration ?>" />
          </div>
          <!-- Note minimale -->
          <div class="mb-3">
            <label class="form-label"><i class="bi bi-star me-1"></i> Note minimale</label>
            <div class="note-stars">
              <input type="hidden" name="note" id="inputNote" value="" />
              <?php for ($i = 1; $i <= 5; $i++) { ?>
                <i class="bi bi-star-fill star" data-value="<?= $i ?>"></i>
              <?php } ?>
            </div>
          </div>
          <!-- Bouton appliquer -->
          <div class="d-grid">
            <button type="submit" name="filter" class="btn btn-outline w-100">Appliquer</button>
          </div>
        </form>

        <!-- Mes covoiturages (desktop) -->
        <?php if (Security::isLogged()) { ?>
        <div class="text-center mt-2 content-text">
          <a href="?controller=covoiturages&action=mesCovoiturages" class="btn btn-filled w-100">Mes covoiturages</a>
        </div>
        <?php } ?>
      </div>
    </aside>

    <!-- Résultats des covoiturages (à droite) -->
    <div class="col-lg-8">
      <!-- Modal des filtres en mode mobile et tablet-->
      <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5 subtitle-text" id="filterModalLabel">
                Filtrer
              </h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
              <form method="post" class="filter-body content-text">
                <!-- Voyage Écologique -->
                <div class="mb-3">
                  <label class="form-label"><i class="bi bi-tree me-1"></i> Voyage Écologique</label>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ecologique"<?= (!empty($_POST['ecologique'])) ? "checked" : "" ?> />
                  </div>
                </div>
                <!-- Prix maximum -->
                <div class="mb-3">
                  <label for="price" class="form-label"><i class="bi bi-c-circle me-1"></i> Prix maximum</label>
                  <input type="number" class="form-control" name="maxPrice" id="price" value="<?= $maxPrice ?>" />
                </div>

                 <div class="mb-3">
                  <label for="duration" class="form-label"><i class="bi bi-clock me-1"></i> Durée maximale</label>
                  <input type="number" class="form-control" name="maxDuration" id="duration" value="<?= $maxDuration ?>" />
                </div>
                <!-- Note minimale -->
                <div class="mb-3">
                  <label class="form-label"><i class="bi bi-star me-1"></i> Note minimale</label>
                  <div class="note-stars">
                    <input type="hidden" name="note" id="inputNote" value="" />
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                      <i class="bi bi-star-fill star" data-value="<?= $i ?>"></i>
                    <?php } ?>
                  </div>
                </div>
                <!-- Footer de la modal -->
                <div class="modal-footer mb-0">
                  <!-- Bouton pour annuler l'ajout des filtres -->
                  <button
                    type="button"
                    class="btn btn-danger content-text text-white"
                    data-bs-dismiss="modal">
                    Annuler
                  </button>
                  <!-- Bouton pour appliquer des filtres -->
                  <button
                    type="submit"
                    class="btn btn-filled content-text" name="filter">
                    Appliquer
                  </button>
                </div>


              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Date -->
      <!-- Le jour et la date du covoiturage, et le bouton pour visualiser les covoiturages de l'utilisateur -->
      <div class="d-flex align-items-center mb-3 justify-content-between">
        <!-- Le jour et la date du covoiturage -->
        <?php if (!empty($covoiturages)) { ?>
          <div class="covoiturage-information">
            <h2 class="day-text"><?= $dayName . ", " . $dayNumber . " " . $monthName ?></h2>
            <p class="address-text"><?= $adresseDepart . ' <i class="bi bi-arrow-right"></i> ' . $adresseArrivee ?></p>
          </div>
        <?php } ?>
      </div>
      <!-- Bouton pour visualiser les covoiturages de l'utilisateur en mode mobile -->
        <?php if (Security::isLogged()) { ?>
          <div class="text-center mes-covoiturages-btn-mobile content-text">
            <!-- Bouton pour afficher les filtres quand on est en mobile ou tablet -->
            <button
              class="btn btn-outline filter-btn small-text"
              data-bs-toggle="modal"
              data-bs-target="#filterModal">
              <i class="bi bi-filter"></i>Filtrer
            </button>
            <a href="?controller=covoiturages&action=mesCovoiturages" class="btn btn-filled shadow-section">Mes covoiturages</a>
          </div>
        <?php } ?>

      <!-- Les cartes avec les résultats de tous les covoiturages -->
      <?php
      if (!empty($covoiturages)) {
        foreach ($covoiturages as $covoiturage) { ?>
          <div class="travel-card mb-4 p-3 border rounded shadow-sm">
            <div class="travel-content">
             <!-- Heures et trajet -->
              <div class="travel-main-line">
                <div class="time-location-group">
                  <span class="travel-time"><?= substr($covoiturage['date_heure_depart'], 11, 5) ?></span>
                  <span class="travel-address text-capitalize"><?= $covoiturage['adresse_depart'] ?></span>
                  <i class="bi bi-arrow-right travel-arrow"></i>
                  <span class="travel-address text-capitalize"><?= $covoiturage['adresse_arrivee'] ?></span>
                  <span class="travel-time"><?= substr($covoiturage['date_heure_arrivee'], 11, 5) ?></span>
                </div>
                <!-- Prix -->
                <div class="price-badge">
                  <p class="headline-text"><?= $covoiturage['prix'] ?></p>
                  <i class="bi bi-c-circle"></i>
                </div>
              </div>
              <!-- Places disponibles -->
               <div class="description-content">
                  <div class="info-badge">
                  <i class="bi bi-car-front-fill"></i>
                  <p><span class="fw-bold"><?= $covoiturage['nb_place_disponible'] ?></span> place(s)</p>
                </div>
                <!-- Voyage Écologique -->
                <div class="info-badge <?= ($energieByCovoiturageId[$covoiturage['id']]['energie_id'] == 1) ? 'eco-badge' : '' ?>">
                  <i class="bi bi-tree-fill"></i>
                  <p><?= ($energieByCovoiturageId[$covoiturage['id']]['energie_id'] == 1) ? "Écologique" : "Non écologique" ?></p>
                </div>
              </div>
            </div>
            <!-- Profil du chauffeur et bouton de détail -->
            <div class="driver-profile">
              <!-- Photo et pseudo -->
              <div class="driver-img">
                <img
                  src="./Uploads/User/<?= 
                  (!empty($driversByCovoiturageId[$covoiturage['id']]['photo_uniqId'])) 
                    ? $driversByCovoiturageId[$covoiturage['id']]['photo_uniqId'] 
                    : "../../Assets/Img_page-vue-covoiturages/driver-default.png" 
                  ?>"
                  alt="Image du chauffeur" />
                <p class="content-text mb-0"><?= $driversByCovoiturageId[$covoiturage['id']]['pseudo'] ?></p>

                <!-- Note -->
                <div class="driver-rating">
                  <i class="bi bi-star-fill text-warning"></i>
                  <p class="mb-0"><?= (!is_null($driverNote[$covoiturage['id']]['note'])) ? $driverNote[$covoiturage['id']]['note'] : "-" ?> / 5</p>
                </div>
              </div>
              <!-- Bouton pour voir plus en détail le covoiturage -->
              <div class="detail-btn-container">
                <a href="?controller=covoiturages&action=showOne&id=<?= $covoiturageEncryptId[$covoiturage['id']] ?>" class="btn btn-filled">
                  <i class="bi bi-info-circle me-1"></i> Détail
                </a>
              </div>
            </div>

          </div>
        <?php  }
      } else { ?>
        <div class="no-results">
            <div class="no-results-icon">
                <i class="bi bi-search"></i>
            </div>
            <h3>Aucun trajet disponible</h3>
            <p>Modifiez vos critères de recherche ou réessayez plus tard</p>
            <div class="text-center headline-text mt-3">
              <a class="btn btn-filled mt-3" href="?controller=page&action=accueil">Cliquez ici pour faire une recherche</a>
            </div>
        </div>
      <?php }
      ?>

    </div>

  </div>
</section>

<?php
require_once BASE_PATH . '/Templates/footer.php';
?>