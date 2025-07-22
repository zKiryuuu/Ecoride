<?php
//HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../public/Styles/new.css"/>
    
</head>


<div class="covoiturage-container">
  <!-- Colonne de gauche - Détails du covoiturage -->
  <div class="covoiturage-details">
    <div class="details-header">
      <h2><?= $dayName . ", " . $dayNumber . " " . $monthName ?></h2>
      <div class="price-badge">
        <span><?= $covoiturageDetail['prix'] ?></span>
        <i class="bi bi-c-circle"></i>
      </div>
    </div>

    <div class="details-content">
      <div class="journey-info">
        <div class="covoiturage-one-info-list d-flex align-items-center justify-content-between">
          <!-- Départ -->
          <div class="covoiturage-date-time text-center">
            <p class="fw-semibold mb-1">Départ</p>
            <p class="mb-1"><?= $heureDepart ?></p>
            <p class="mb-0"><?= $covoiturageDetail['adresse_depart'] ?></p>
          </div>
          <!-- Flèche + durée, en colonne -->
          <div class="arrow-duration d-flex flex-column align-items-center mx-3">
            <i class="bi bi-arrow-right fs-2"></i>
            <span class="duration-text mt-1">Durée: <?= $dureeCovoiturage->format('%Hh%I') ?></span>
          </div>
          <!-- Arrivée -->
          <div class="covoiturage-date-time text-center">
            <p class="fw-semibold mb-1">Arrivée</p>
            <p class="mb-1"><?= $heureArrivee ?></p>
            <p class="mb-0"><?= $covoiturageDetail['adresse_arrivee'] ?></p>
          </div>
        </div>

        <div class="car-info">
          <div class="info-item">
            <i class="bi bi-car-front-fill"></i>
            <span>Places disponibles : <?= $covoiturageDetail['nb_place_disponible'] ?></span>
          </div>
          <div class="info-item">
            <i class="bi bi-tree-fill"></i>
            <span>Voyage Écologique : <?= ($carInfo['energie'] == "Électrique") ? "Oui" : "Non" ?></span>
          </div>
          <div class="info-item">
            <i class="bi bi-lightning-charge-fill"></i>
            <span>Énergie : <?= $carInfo['energie'] ?></span>
          </div>
          <div class="info-item">
            <i class="fa-solid fa-car-side"></i>
            <span><?= $carInfo['marque'] ?> <?= $carInfo['modele'] ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Colonne de droite - Informations conducteur et participation -->
  <div class="driver-section">
    <div class="driver-profile">
      <img src="./Uploads/User/<?= !empty($driver['photo_uniqId']) ? $driver['photo_uniqId'] : "../../Assets/Img_page-vue-covoiturages/driver-default.png" ?>" alt="Photo conducteur">
      <div class="driver-info">
        <h3><?= $driver['pseudo'] ?></h3>
        <div class="rating">
          <i class="bi bi-star-fill"></i>
          <span><?= (!is_null($driverNote['note'])) ? $driverNote['note'] : "-" ?> / 5</span>
        </div>
      </div>
    </div>

    <div class="preferences-section">
      <h3>Préférences</h3>
      <ul>
        <li>
          <span>Fumeur :</span>
          <?= in_array("Fumeur", $preferences) ? 'Accepté' : 'Non accepté' ?>
        </li>
        <li>
          <span>Animaux :</span>
          <?= in_array("Animal", $preferences) ? 'Acceptés' : 'Non acceptés' ?>
        </li>
        <?php foreach ($preferencesPersonnelles as $preference): ?>
          <?php if (!empty($preference)): ?>
            <li><?= ucfirst($preference) ?></li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </div>
    <!-- Les avis du chauffeur -->
    <div class="comments">
      <!-- Titre -->
      <h2 class="subtitle-text">Avis</h2>
      <!-- List des avis -->
      <ul class="w-100">
        <!-- Si le chauffeur a des avis validés -->
        <?php if (!empty($avisValidated)) { ?>
          <?php foreach ($allDriverAvis as $avis) { ?>
            <!-- Pour récuperer l'id de l'avis et le transformer en string -->
            <?php $avisId = (string) $avis['_id']; ?>
            <!-- On affiche uniquement les avis qui ont été déjà validés par l'employé, donc, avec le statut = 1 -->
            <?php if ($avis['accepte'] == 1) { ?>
              <li>
                <div class="user-comment">
                  <!-- Pseudo de la personne qui laisse l'avis -->
                  <p class="small-text"><?= $passagerPseudo[$avisId]['pseudo'] ?></p>
                  <!-- Titre et note de l'avis -->
                  <div class="small-text comment-title">
                    <!-- Titre de l'avis -->
                    <p><?= $avis['titre'] ?></p>
                    <!-- La note -->
                    <div class="note-stars">
                      <!-- Boucle pour imprimir une étoile selon la note donnée -->
                      <?php for ($i = 0; $i < $avis['note']; $i++) {
                        echo '<i class="bi bi-star-fill"></i>';
                      } ?>
                    </div>
                  </div>
                  <!-- L'avis -->
                  <p class="small-text">
                    <?= $avis['avis'] ?>
                  </p>
                </div>
              </li>
            <?php }  ?>
          <?php } ?>
        <?php } else { ?>
          <li>
            <!-- Si le chauffeur n'a pas des avis -->
            <div class="user-comment">
              <p class="small-text">Aucun avis pour le moment.</p>
            </div>
          </li>
        <?php } ?>
      </ul>
    </div>

    <button 
      class="btn btn-outline" 
      data-bs-toggle="modal" 
      data-bs-target="#participateConfirmation">
      Réserver ce trajet
    </button>

  </div>
</div>

<!-- Modal avec les messages d'erreur ou la confirmation pour participer au covoiturage -->
    <div class="modal fade" 
          id="participateConfirmation" 
          data-bs-backdrop="static" 
          data-bs-keyboard="false" 
          tabindex="-1" 
          aria-labelledby="participateConfirmationLabel" 
          aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <!-- Le contenu de la modal -->
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Covoiturage</h1>
            <!-- Bouton pour fermer la modal -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <!-- Si l'utilisateur n'est pas connecté, alors, on affiche un message 
            et on propose de se connecter ou créer un compte -->
          <?php if (!isset($_SESSION['user'])) { ?>
            <div class="alert alert-danger mb-0 p-5 text-center content-text" role="alert">
              <p class="mb-4"><strong>Attention :</strong> Vous devez être connecté pour participer à ce trajet.</p>
              <!-- Liens pour se connecter ou créer un compte  -->
              <div class="d-flex gap-3 justify-content-center align-items-center text-white">
                <a href="?controller=auth&action=logIn" class="btn btn-light content-text ">Se connecter</a>
                <p class="mb-0"> | </p>
                <a href="?controller=user&action=singUp" class="btn btn-light content-text ">S'inscrire</a>
              </div>
            </div>
            <!-- Si l'utilisateur participe déjà au covoiturage -->
          <?php } elseif ($isUserParticipant) { ?>
            <div class="alert alert-danger mb-0 p-5 text-center content-text" role="alert">
              <strong>Vous participez déjà à ce covoiturage.</strong><br>
              Il n’est pas possible de s’inscrire plusieurs fois au même trajet.
            </div>
            <!-- Si l'utilisateur est le chauffeur du covoiturage -->
          <?php } elseif ($isDriverInCovoiturage) { ?>
            <div class="alert alert-danger mb-0 p-5 text-center content-text" role="alert">
              <strong>Vous êtes le conducteur de ce covoiturage.</strong><br>
              En tant que chauffeur, vous ne pouvez pas vous inscrire comme passager à votre propre trajet.
            </div>
            <!-- Si le covoiturage n'a plus des places disponibles-->
          <?php } elseif ($noDisponiblePlaces) { ?>
            <div class="alert alert-danger mb-0 p-5 text-center content-text" role="alert">
              <strong>🚫 Trajet complet !</strong> Il n'y a plus de places disponibles.
            </div>
            <!-- Si l'utilisateur ne possède pas assez des crédits pour participer au covoiturage-->
          <?php } elseif ($noEnoughCredits) { ?>
            <div class="alert alert-danger mb-0 p-5 text-center content-text" role="alert">
              <strong>💰 Crédits insuffisants !</strong>
              Vous avez besoin de <?= $covoituragePrice ?> crédits pour participer, mais vous n'avez que <?= $userCredits ?> crédits.
            </div>
            <!-- Pour afficher la modale de double confimation -->
          <?php } elseif ($doubleConfirmation) { ?>
            <!-- Formulaire pour participer au covoiturage  -->
            <form method="post" class="w-100 d-flex align-items-center flex-column gap-4 p-5 text-center mb-0 form" id="participateForm">
              <!-- Input cache pour passer les donnes dans la requête sql -->
              <input type="text" name="user_id" hidden value="<?= (isset($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : "" ?>">
              <!-- Input cache pour passer les donnes dans la requête sql -->
              <input type="text" name="covoiturage_id" hidden value="<?= $covoiturageDetail['id'] ?>">
              <label class="content-text text-center fw-medium">Voulez-vous confirmer votre participation et l’utilisation de <?= $covoituragePrice ?> crédits ?</label>
              <!-- Boutons pour confirmer ou annuler -->
              <div class="d-flex gap-3 justify-content-center">
                <button type="button" value="" class="btn btn-danger shadow-section text-light content-text secondary-btn" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                <input type="submit" class="btn btn-filled shadow-section text-white content-text secondary-btn" value="Confirmer" name="participate">
              </div>
            </form>
          <?php } ?>
          </div>  

        </div>
      </div>
    </div>

<?php
require_once  BASE_PATH . '/Templates/footer.php';
?>