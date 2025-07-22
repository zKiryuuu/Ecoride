<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-card">
            <h2>Se connecter</h2>
            <!-- Lien si l'utilisateur n'a pas un compte, pour s'en créer un -->
            <p class="auth-subtitle">Pas encore membre ? <a href="?controller=user&action=singUp">Inscrivez-vous</a></p>
            <!-- Formulaire pour se connecter -->
            <form method="post" class="auth-forms">
                <div class="form-group">
                    <!-- Tous les champs du formulaire -->
                     <div class="form-floating mb-3 ">
                        <input type="email" name="mail" class="form-control content-text
                        <?= (isset($errors['mail'])) || (isset($errors['invalidUser'])) ? "is-invalid" : "" ?>"
                            id="floatingInput" placeholder="name@example.com" value="<?= $mail ?>">
                        <label for="floatingInput" class="content-text">Adresse e-mail</label>
                        <!-- Si il y a des erreurs on affiche le message d'erreur -->
                        <?php if (isset($errors['mail'])) { ?>
                            <div class="invalid-tooltip"><?= $errors['mail'] ?></div>
                        <?php } ?>
                    </div>
                    <!-- Mot de passe -->
                    <div class="form-floating mb-5">
                        <input type="password" name="password" class="form-control content-text
                        <?= (isset($errors['invalidUser'])) ? "is-invalid" : "" ?>" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword" class="content-text">Mot de passe</label>
                        <!-- message et button pour afficher le mot de passe -->
                        <div class="show-password">
                            <span class="text-black small-text" id="showPasswordText">Afficher le mot de passe</span>
                            <i class="bi bi-square" id="showPasswordIcon"></i>
                        </div>
                    </div>
                </div>
                <!-- Erreur si le mail ou le mot de passe sont incorrect -->
                <?php if (isset($errors['invalidUser'])) { ?>
                    <div class="if-form-error d-flex justify-content-center content-text">
                        <div class="alert alert-danger mt-3 content-text text-center"><?= $errors['invalidUser'] ?></div>
                    </div>
                <?php } ?>
                <!-- Erreur si le compte est suspendu -->
                <?php if (isset($errors['inactiveUser'])) { ?>
                    <div class="if-form-error d-flex justify-content-center content-text">
                        <div class="alert alert-danger mt-3 content-text text-center"><?= $errors['inactiveUser'] ?></div>
                    </div>
                <?php } ?>
                <!-- Button de connexion -->
                <div class="d-flex justify-content-center">
                    <button class="btn btn-filled w-100" name="logIn" type="submit">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</section>


<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>