<!-- Mail pour les participants du covoituage quand le chauffeur indique avoir arrivé à destination -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        p,
        a,
        li {
            font-size: 18px;
            line-height: 1.5;
            color: #333;
        }
    </style>
    <title>Mail</title>
</head>

<body>
    <p>Bonjour <?= $passagerPseudo ?>,</p>
    <p>
        Votre covoiturage du <strong><?= $covoiturageDateDepart ?></strong>
        avec le conducteur <strong><?= $driverPseudo ?></strong> est désormais terminé.
        Nous espérons que tout s’est bien passé ! 🚗💨
    </p>
    <p>
        Afin de finaliser cette expérience, merci de vous rendre dans votre espace personnel pour :
    </p>
    <ul style="list-style: none; padding-left: 0">
        <li>✅ Confirmer que le trajet s’est bien déroulé</li>
        <li>✍🏽 Laisser un avis et une note sur le chauffeur (optionnel)</li>
    </ul>
    <a href="<?= $linkToSite ?>"> 🔗 Accéder à mon espace </a>
    <p>
        ⚠️ Si vous avez rencontré un problème durant ce trajet, vous aurez la possibilité d’ajouter un commentaire.
        Un membre de notre équipe vous contactera rapidement afin de résoudre la situation.
    </p>
    <p>À très bientôt sur EcoRide!</p>
    <p>L'équipe de Covoiturage</p>
</body>

</html>