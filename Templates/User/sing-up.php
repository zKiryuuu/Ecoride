<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';

?>

<!-- main -->

<section class="auth-section">
  <div class="container">
    <div class="auth-card">
        <!-- Formulaire pour créer un compte utilisateur -->
        <form method="post" class="auth-forms" enctype="multipart/form-data">
          <!-- titre -->
          <h2>Inscription</h2>
          <p class="auth-subtitle">déjà membre ? <a href="?controller=auth&action=logIn">Connectez-vous</a></p>

          <!-- Tous les champs du formulaire de l'utilisateur -->
          <div class="d-flex flex-column align-items-center content-text gap-3">
            <!-- Pseudo -->
            <div class="content-text">
              <input type="text" name="pseudo" class="form-control content-text
                      <?= (isset($errors['pseudoEmpty'])) ? "is-invalid" : "" ?>"
                id="floatingInput" placeholder="Speudo" value="<?= $pseudo ?>">
              <label for="floatingPseudo" class="content-text">Pseudo</label>
              <!-- Si il y a des erreurs on affiche le message d'erreur -->
              <?php if (isset($errors['pseudoEmpty'])) { ?>
                <div class="alert alert-danger position-static small-text"><?= $errors['pseudoEmpty'] ?></div>
              <?php } ?>
            </div>
            <!-- E-mail -->
            <div class="">
              <input type="email" class="form-control content-text
              <?= (isset($errors['mailEmpty'])) || (isset($errors['mailUsed'])) ? "is-invalid" : "" ?>"
                id="floatingMail" name="mail" placeholder="name@example.com" value="<?= $mail ?>">
              <label for="floatingMail" class="content-text">Email address</label>
              <!-- Si il y a des erreurs on affiche le message d'erreur -->
              <?php if (isset($errors['mailEmpty'])) { ?>
                <div class="invalid-tooltip position-static small-text"><?= $errors['mailEmpty'] ?></div>
                <!-- Si le mail est déjà utilisé -->
              <?php } elseif (isset($errors['mailUsed'])) { ?>
                <div class="invalid-tooltip position-static small-text"><?= $errors['mailUsed'] ?></div>
              <?php } ?>
            </div>
            <!-- Mot de passe -->
            <div class="form-floating">
              <input type="password" class="form-control content-text
              <?= (isset($errors['passwordEmpty'])) || (isset($errors['passwordLen'])) || (isset($errors['passwordInfo'])) ? "is-invalid" : "" ?>"
                id="floatingPassword" name="password" placeholder="Password" value="<?= $password ?>">
              <label for="floatingPassword" class="content-text">Mot de passe</label>
              
              <!-- Si il y a des erreurs on affiche le message d'erreur -->
              <?php if (isset($errors['passwordEmpty'])) { ?>
                <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text"><?= $errors['passwordEmpty'] ?></div>
                <!-- Si le mot de passe a moins de 12 caractères   -->
              <?php } elseif (isset($errors['passwordLen'])) { ?>
                <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text"><?= $errors['passwordLen'] ?></div>
                <!-- si le mot de passe ne respecte pas les requis d'une mot de passe secure -->
              <?php } elseif (isset($errors['passwordInfo'])) { ?>
                <div class="invalid-tooltip position-static invalid-tooltip-mdp small-text"><?= $errors['passwordInfo'] ?></div>
              <?php } ?>
              <!-- message et button pour afficher le mot de passe -->
              <div class="show-password">
                <span class="text-black small-text" id="showPasswordText">Afficher le mot de passe</span>
                <i class="bi bi-square" id="showPasswordIcon"></i>
              </div>
              
            </div>
            <!-- Sélectionner le role -->
            <div class="mt-2">
              <label for="roleSelect" class="text-center text-white content-text">Je suis : </label>
              <select class="form-select content-text 
              <?= (isset($errors['roleEmpty'])) ? "is-invalid" : "" ?>" name="role_id" id="roleSelect">
                <option value="<?= ($roleId) ? $roleId : "" ?>"><?= $roleName ?></option>
                <option value="1">Passager</option>
                <option value="2" class="driverRole">Chauffeur</option>
                <option value="3" class="driverRole">Chauffeur et passageur</option>
              </select>
              <!-- Si il y a des erreurs on affiche le message d'erreur -->
              <?php if (isset($errors['roleEmpty'])) { ?>
                <div class="invalid-tooltip position-static small-text"><?= $errors['roleEmpty'] ?></div>
              <?php } ?>
            </div>
            <!-- Si l'utilisateur a un role chauffeur, alors, formulaire pour enregistrer la photo -->
            <div class="mt-2 d-flex if-chauffeur non-chauffeur content-text" id="driverForm">
              <!-- la photo du chauffeur -->
              <div class="d-flex flex-column gap-3 driver-form">
                <!-- Ajouter la photo -->
                <div>
                  <label for="driverImage" class="form-label">Ajoutez votre photo du profil</label>
                  <input type="file" name="photo" class="form-control content-text" id="driverImage">
                  <!-- Si il y a des erreurs on affiche le message d'erreur -->
                  <?php if (isset($errors['fileEmpty'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['fileEmpty'] ?></div>
                    <!-- S'il y a une erreur au moment de charger l'image -->
                  <?php } elseif (isset($errors['fileError'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['fileError'] ?></div>
                    <!-- Si l'extention n'est pas valide -->
                  <?php } elseif (isset($errors['fileExtError'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['fileExtError'] ?></div>
                    <!-- Si la taille est superieure à 2 Mo -->
                  <?php } elseif (isset($errors['fileSizeError'])) { ?>
                    <div class="invalid-tooltip position-static small-text"><?= $errors['fileSizeError'] ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>  
          <!-- Button pour créer le compte -->
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-filled w-100" name="singUp" type="submit">Se registrer</button>
          </div>
        </form>
    </div>
  </div>
</section>

<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>