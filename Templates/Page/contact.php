<?php
// HEADER
require_once  BASE_PATH . '/Templates/header.php';
?>

<!-- main -->
<section class="container py-5">
    <div class="form-template">
        <div class="form-header">
            <h2>Contactez nous</h2>
            <p>Renseignez les détails de votre trajet</p>
        </div>
        <!-- Formulaire pour envoyer le message -->
        <form method="post" class="contact-form">
            <!-- Pseudo et Email-->
            <div class="form-section">
                <!-- Pseudo -->
                <div class="form-group content-text">
                    <label for="Pseudo" class="form-labe">Pseudo</label>
                    <input type="text" name="Pseudo" id="Pseudo" class="form-control" placeholder="Joe" required>
                </div>
                <!-- Email -->
                <div class="form-group content-text">
                    <label for="email" class="form-labe">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="joe@gmail.com" required>
                </div>
            </div>
            <!-- Message -->
            <div class="form-group content-text">
                <label for="message" class="form-labe">Message</label>
                <textarea name="message" id="message" class="form-control" placeholder="Votre message" required></textarea>
            </div>
            <!-- Bouton pour envoyer le formulaire -->
            <div class="form-submit">
                <button type="submit" class="btn btn-filled w-100">Envoyer</button>
            </div>
        </form>
    </div>
</section>


<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>