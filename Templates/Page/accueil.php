<?php
// HEADER
require_once BASE_PATH . '/Templates/header.php';
?>

<main>
  <!-- Section Hero (slogan + formulaire de recherche) -->
  <section class="hero-section">
    <div class="container">
      <div class="slogan" id="slogan">
        <h2 class="subtitle-text text-white">
          Voyagez avec EcoRide <br />
          le covoiturage écologique à votre portée.
        </h2>

        <div class="search-bar">
          <form method="get">
            <div class="d-flex">
              <!-- Adresse départ -->
              <div>
                <i class="bi bi-record-circle"></i>
                <input type="text" name="adresse_depart" placeholder="Adresse de départ"
                  value="<?= $adresseDepart ?>"
                  class="form-control content-text <?= isset($errors['adresseDepartEmpty']) ? 'is-invalid' : '' ?>" />
                <?php if (isset($errors['adresseDepartEmpty'])): ?>
                  <div class="invalid-tooltip"><?= $errors['adresseDepartEmpty'] ?></div>
                <?php endif; ?>
              </div>

              <!-- Adresse arrivée -->
              <div>
                <i class="bi bi-geo-alt-fill"></i>
                <input type="text" name="adresse_arrivee" placeholder="Adresse d’arrivée"
                  value="<?= $adresseArrivee ?>"
                  class="form-control content-text <?= isset($errors['adresseArriveeEmpty']) ? 'is-invalid' : '' ?>" />
                <?php if (isset($errors['adresseArriveeEmpty'])): ?>
                  <div class="invalid-tooltip"><?= $errors['adresseArriveeEmpty'] ?></div>
                <?php endif; ?>
              </div>

              <!-- Date -->
              <div class="date">
                <i class="bi bi-calendar2-week-fill"></i>
                <input type="date" name="date_heure_depart" value="<?= $dateDepart ?>"
                  class="form-control content-text <?= isset($errors['dateDepartEmpty']) ? 'is-invalid' : '' ?>" />
                <?php if (isset($errors['dateDepartEmpty'])): ?>
                  <div class="invalid-tooltip"><?= $errors['dateDepartEmpty'] ?></div>
                <?php endif; ?>
              </div>
            </div>

            <!-- Résultats ou erreurs -->
            <?php if (!empty($covoiturageCloser)): ?>
              <div class="alert alert-warning">
                <p>Aucun covoiturage à cette date. Une alternative est disponible le
                  <?= $newDateDepart->format("d-m-Y") ?>.</p>
              </div>
            <?php elseif (!empty($noCovoiturageFoundMsg)): ?>
              <div class="alert alert-danger">
                <p><?= $noCovoiturageFoundMsg ?></p>
              </div>
            <?php endif; ?>

            <!-- Bouton de recherche -->
            <div class="d-flex">
              <div class="search-btn">
                <button class="btn btn-primary" type="submit" name="search">Rechercher</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

<!-- Section Pourquoi choisir EcoRide -->
<section class="why-ecoride">
    <div class="container">
        <h2 class="section-title">Les avantages du covoiturage écologique</h2>
        <div class="benefits">
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-globe-americas"></i>
                </div>
                <h3>Impact environnemental</h3>
                <p>Diminuez votre empreinte carbone en partageant vos trajets. Chaque covoiturage permet d'éviter jusqu'à 2,2 kg de CO<sub>2</sub> par personne et par trajet, contribuant activement à la préservation de notre planète.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-piggy-bank"></i>
                </div>
                <h3>Réduction des coûts</h3>
                <p>Partagez les frais de transport et économisez jusqu'à 70% sur vos déplacements quotidiens. Entre carburant, entretien et stationnement, le covoiturage représente une solution intelligente pour votre portefeuille.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Connexions humaines</h3>
                <p>Transformez vos trajets en moments d'échange et de partage. Le covoiturage favorise les rencontres enrichissantes et permet de tisser des liens avec des personnes partageant votre itinéraire et potentiellement vos centres d'intérêt.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-car"></i>
                </div>
                <h3>Mobilité optimisée</h3>
                <p>Contribuez à décongestionner les routes en réduisant le nombre de véhicules en circulation. Un covoiturage régulier peut diminuer le trafic urbain jusqu'à 25%, améliorant ainsi la qualité de vie dans nos villes.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section À propos -->
<section class="about">
    <div class="container">
        <h2 class="section-title">Faisons connaissance...</h2>
        <div class="about-content">
            <p><strong>Conduire propre. Un avenir plus vert.</strong> Nos voitures électriques sont non seulement respectueuses de l'environnement, mais elles offrent aussi un confort moderne et une conduite fluide. Profitez d'une expérience de covoiturage sans pollution, tout en contribuant à un monde plus propre.</p>
            <p><strong>Une communauté soudée. Unie par l'écologie.</strong> Notre plateforme réunit des personnes partageant les mêmes valeurs. Ensemble, nous pouvons réduire l'empreinte carbone et adopter des pratiques de mobilité plus durables. Grâce au covoiturage électrique, nous construisons un réseau de conducteurs et de passagers qui soutiennent un avenir durable.</p>
            <p><strong>Notre impact, votre avenir. Réduisez les émissions dès aujourd'hui.</strong> En adoptant le covoiturage électrique, vous faites partie de la solution. Réduisez les émissions de CO2 tout en voyageant de manière économique et conviviale. Avec EcoRide, chaque trajet compte pour un avenir plus sain.</p>
            <p class="join-us">Ensemble, créons un avenir plus vert en participant à la <strong>révolution de la mobilité durable</strong> avec <strong>EcoRide</strong> !</p>
            <a href="?controller=page&action=contact" class="contact-box">
            <div class="contact-container">
              <p>Une question ? Contactez-nous</p>
            </div>
          </a>
        </div>
    </div>
</section>

</main>

<script src="./Scripts/searchCovoiturage.js"></script>

<?php
// FOOTER
require_once BASE_PATH . '/Templates/footer.php';
?>
