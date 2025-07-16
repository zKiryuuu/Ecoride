<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<section class="container mt-5 mb-5">
    <div class="card shadow-sm">
        <!-- Formulaire pour envoyer le message -->
        <form method="post" class="card-body contact-form">
            <!-- Titre -->
            <h2 class="subtitle-text fs-4 text-center">Contactez nous</h2>
            <!-- Pseudo et Email-->
            <div class="d-flex card-body user-info">
                <!-- Pseudo -->
                <div class="content-text">
                    <label for="Pseudo" class="form-labe">Pseudo</label>
                    <input type="text" name="Pseudo" id="Pseudo" class="form-control" placeholder="Joe" required>
                </div>
                <!-- Email -->
                <div class="content-text">
                    <label for="email" class="form-labe">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="joe@gmail.com" required>
                </div>
            </div>
            <!-- Message -->
            <div class="content-text">
                <label for="message" class="form-labe">Message</label>
                <textarea name="message" id="message" class="form-control" placeholder="Votre message" required></textarea>
            </div>
            <!-- Bouton pour envoyer le formulaire -->
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-large btn-primary">Envoyer</button>
            </div>
        </form>
    </div>
</section>


<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>