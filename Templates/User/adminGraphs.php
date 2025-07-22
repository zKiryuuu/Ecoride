<?php
// HEADER
use App\Security\Security;

require_once  BASE_PATH . '/Templates/header.php';
?>

<!-- Section avec les graphiques de l'app. le canvas est rempli dynamiquement par le fichier JS-->
<section class="container rounded bg-light p-3 mt-4 mb-5 d-flex justify-content-center">
  <div class="col-12 col-md-10 chart-container">
    <h2 class="text-center subtitle-text">Graphique de la plateforme</h2>
    <!-- Canvas pour le graphique -->
    <canvas id="myChart" class="d-inline"></canvas>
  </div>

</section>


<?php
// FOOTER
require_once  BASE_PATH . '/Templates/footer.php';
?>