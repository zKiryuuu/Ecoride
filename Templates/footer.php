</main>

<footer class="footer-container">
    <div class="footer-content">
        <div class="footer-info">
            <a href="mailto:contact@ecoride.fr" class="footer-link">contact@ecoride.fr</a>
            <div class="footer-separator"></div>
            <a href="?controller=page&action=accueil" class="footer-brand">EcoRide</a>
            <div class="footer-separator"></div>
            <a href="?controller=page&action=legalMentions" class="footer-link">Mentions légales</a>
        </div>
        <p class="footer-tagline">Réduisez votre empreinte écologique en covoiturant.</p>
        <p class="footer-copyright">© 2025 EcoRide. Tous droits réservés.</p>
    </div>
</footer>

<!--Import du JS du Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Import du JS pour la librairie DataTable -->
<?php if (isset($_GET['action']) && $_GET['action'] == 'adminEspace') { ?>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
<?php } ?>
<!-- Import du JS pour la librairie Chart.js -->
<?php if (isset($_GET['action']) && $_GET['action'] == 'adminGraphs') { ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php } ?>
<!-- Import du propre JS-->
<?php
// Tableau avec les scripts js pour chaque page, dont l'action est la clé et les scripts les valeurs
$scripts = [
    'showAll' => ['driverNote.js'],
    'allCovoiturages' => ['driverNote.js'],
    'validateCovoiturage' => ['driverNote.js', 'validateCovoiturage.js'],
    'logIn' => ['showPassword.js'],
    'singUp' => ['showPassword.js', 'driverForm.js'],
    'preferencesInscription' => ['preferencesForm.js'],
    'profil' => ['preferencesForm.js'],
    'accueil' => ['searchCovoiturage.js', 'mobileUsage.js'],
    'mesCovoiturages' => ['startCovoiturage.js'],
    'validateAvisAndComments' => ['employeEspace.js'],
    'adminEspace' => ['showPassword.js', 'adminEspace.js'],
    'adminGraphs' => ['adminGraphs.js']
];
// Pour récupérer l'action dans l'url 
$currentAction = $_GET['action'] ?? '';
// Si l'action est dans le tableau, alors, 
// on parcours le tableau et on crée une balise script pour chaque script de l'action
if (isset($scripts[$currentAction])) {
    foreach ($scripts[$currentAction] as $script) {
        echo "<script src=\"./Script/{$script}\"></script>\n";
    }
}
?>
</body>

</html>