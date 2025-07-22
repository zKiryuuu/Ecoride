<!-- Mail pour les participants du covoituage quand il est annulé par le chauffeur -->
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    p,
    li {
      font-size: 18px;
      line-height: 1.5;
      color: #333;
    }
  </style>
  <title>Mail</title>
</head>

<body>
  <p>Chers participants,</p>
  <p>
    Nous vous informons que le chauffeur <strong><?= $driverPseudo ?></strong> a malheureusement
    annulé le trajet prévu. Nous comprenons que cela puisse être contraignant
    et nous nous excusons pour la gêne occasionnée.
  </p>
  <ul style="list-style: none; padding-left: 0">
    <li style="margin-left: 0"><strong>📍 Trajet annulé :</strong></li>
    <li><strong>🚘 Départ :</strong> <?= $covoiturageDepart ?></li>
    <li><strong>🏁 Arrivée :</strong> <?= $covoiturageArrivee ?></li>
    <li><strong>🗓️ Date :</strong> <?= $covoiturageDateDepart ?></li>
  </ul>
  <p>
    Si vous avez la moindre question, notre équipe est là pour vous aider.
    N’hésitez pas à nous contacter !
  </p>
  <p>À très bientôt sur EcoRide!</p>
  <p>L'équipe de Covoiturage</p>
</body>

</html>