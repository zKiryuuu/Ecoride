<?php
//HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<head>
    <link rel="stylesheet" href="./Styles/new.css"/>
</head>

<section class="container py-5">
    <div class="form-template">
        <div class="form-header">
            <h2>Créer un nouveau covoiturage</h2>
            <p>Renseignez les détails de votre trajet</p>
        </div>
        
        <form method="post" class="d-flex flex-column">
            <div class="form-section">
                <h5>Date et heure</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <!-- Date et heure de départ -->
                            <label for="dateTimeDepart" class="form-label content-text">Date et heure de départ:</label>
                            <input type="datetime-local" name="date_heure_depart" id="dateTimeDepart"
                                value="<?= (!empty($dateTimeDepart)) ? $dateTimeDepart->format("Y-m-d H:i") : ''; ?>"
                                class="form-control content-text <?= (isset($errors['dateTimeDepartEmpty'])) ? "is-invalid" : "" ?>">
                            <!-- Si il y a des erreurs on affiche le message d'erreur -->
                            <?php if (isset($errors['dateTimeDepartEmpty'])) { ?>
                                <div class="invalid-tooltip position-static small-text"><?= $errors['dateTimeDepartEmpty'] ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <!-- Date et heure d'arrivée -->
                            <label for="dateTimeArrivee" class="form-label content-text">Date et heure d'arrivée:</label>
                            <input type="datetime-local" name="date_heure_arrivee" id="dateTimeArrivee"
                                value="<?= (!empty($dateTimeArrivee)) ? $dateTimeArrivee->format("Y-m-d H:i") : ''; ?>"
                                class="form-control content-text <?= (isset($errors['dateTimeArriveeEmpty'])) ? "is-invalid" : "" ?>">
                            <!-- Si il y a des erreurs on affiche le message d'erreur -->
                            <?php if (isset($errors['dateTimeArriveeEmpty'])) { ?>
                                <div class="invalid-tooltip position-static small-text"><?= $errors['dateTimeArriveeEmpty'] ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                         <div class="form-group">
                            <!-- Adresse de départ-->
                            <label for="adresseDepart" class="form-label content-text">Adresse de départ:</label>
                            <input type="text" name="adresse_depart" id="adresseDepart"
                                value="<?= $adresseDepart ?>"
                                class="form-control content-text <?= (isset($errors['adresseDepartEmpty'])) ? "is-invalid" : "" ?>">
                            <!-- Si il y a des erreurs on affiche le message d'erreur -->
                            <?php if (isset($errors['adresseDepartEmpty'])) { ?>
                                <div class="invalid-tooltip position-static small-text"><?= $errors['adresseDepartEmpty'] ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                         <div class="form-group">
                            <!-- Adresse d'arrivée -->
                            <label for="adresseArrivee" class="form-label content-text">Adresse d'arrivée:</label>
                            <input type="text" name="adresse_arrivee" id="adresseArrivee"
                                value="<?= $adresseArrivee ?>"
                                class="form-control content-text <?= (isset($errors['adresseArriveeEmpty'])) ? "is-invalid" : "" ?>">
                            <!-- Si il y a des erreurs on affiche le message d'erreur -->
                            <?php if (isset($errors['adresseArriveeEmpty'])) { ?>
                                <div class="invalid-tooltip position-static small-text"><?= $errors['adresseArriveeEmpty'] ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                         <div class="form-group">
                            <!-- Nombre des places disponibles -->
                            <label for="nbPlaceDisponible" class="form-label content-text">Nombre des places disponibles:</label>
                            <input type="number" name="nb_place_disponible" id="nbPlaceDisponible"
                                value="<?= (!empty($nbPlaceDisponibles)) ? $nbPlaceDisponibles : '0'; ?>"
                                class="form-control content-text <?= (isset($errors['nbPlaceEmpty'])) ? "is-invalid" : "" ?>">
                            <!-- Si il y a des erreurs on affiche le message d'erreur -->
                            <?php if (isset($errors['nbPlaceEmpty'])) { ?>
                                <div class="invalid-tooltip position-static small-text"><?= $errors['nbPlaceEmpty'] ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                         <div class="form-group">
                            <!-- Prix -->
                            <label for="prix" class="form-label content-text">Prix:</label>
                            <input type="number" name="prix" id="prix"
                                value="<?= (!empty($prix)) ? $prix : '0'; ?>"
                                class="form-control content-text<?= (isset($errors['prixEmpty'])) ? "is-invalid" : "" ?>">
                            <!-- Si il y a des erreurs on affiche le message d'erreur -->
                            <?php if (isset($errors['prixEmpty'])) { ?>
                                <div class="invalid-tooltip position-static small-text"><?= $errors['prixEmpty'] ?></div>
                            <?php } ?>
                            <!-- Text pour donner info à l'utilisateur -->
                            <span class="form-text small-text text-dark">2 crédits sont déduits pour le bon fonctionnement de la plateforme</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="car-select-container">
                        <!-- Sélecctioner la voiture du covoiturage ou bouton pour créer en enregistrer une nouvelle -->
                        <label for="voitureId" class="text-center content-text">Sélecctioner la voiture utilisée: </label>
                        <select class="form-select content-text text-dark bg-light" name="voiture_id" id="voitureId">
                            <option value="0"></option>
                            <!-- Boucle qui affiche les option avec toutes les voitures de l'utilisateur
                             et le value c'est l'id de chaque voiture -->
                            <?php foreach ($cars as $car) { ?>
                                <option value="<?= $car['id'] ?>">
                                    <?=
                                    "Marque: " . $car['marque'] . ", " .
                                        "Modèle: " . $car['modele'] . ", " .
                                        "Immatriculation: " . $car['immatriculation']
                                    ?>
                                </option>
                            <?php } ?>
                        </select>
                        <!-- Si il y a des erreurs on affiche le message d'erreur -->
                        <?php if (isset($errors['voitureEmpty'])) { ?>
                            <div class="invalid-tooltip position-static small-text"><?= $errors['voitureEmpty'] ?></div>
                        <?php } ?>
                        <!-- Lien pour enregistrer une nouvelle voiture -->
                        <a href="?controller=voiture&action=carInscription" class="add-car-link">
                            <i class="bi bi-plus-circle"></i>Enregistrer une nouvelle voiture
                        </a>
                    </div>
                </div>
            </div>
            <div class="form-submit">
                <button type="submit" class="btn btn-filled w-100" name="createCovoiturage" type="submit">Créer le covoiturage</button>
            </div>
        </form>
    </div>
</section>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>