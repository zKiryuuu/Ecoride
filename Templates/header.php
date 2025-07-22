<?php

use App\Security\Security;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--Import des fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!--Import de Font Awesome pour les icons-->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- DataTable JS library CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css" />
    <!-- Import les Bootstrap icons avec CDN -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--Import des styles-->
    <link rel="stylesheet" href="/Styles/style.css"/>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">

    <title>EcoRide</title>
</head>

<body>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>

<header id="main-header">
        <div class="container">
            <div class="logo">
                <img src="./Public/Assets/Logo/logo-primary.png" alt="Logo EcoRide">
                <a href="?controller=page&action=accueil">
                    <h1>EcoRide</h1>
                </a>
            </div>
            <nav>
                <ul class="desktop-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=page&action=accueil">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=covoiturages&action=showAll">Covoiturage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=page&action=contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=page&action=ui">Ui</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=page&action=test">Test</a>
                    </li>
                </ul>
                <div class="user-menu">
                    <button class="user-btn">
                        <i class="fas fa-user-circle"></i>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <?php if (Security::islogged()): ?>
                            <?php if (Security::isAdmin()): ?>
                                <a href="?controller=admin&action=dashboard">Administration</a>
                            <?php endif; ?>
                            <a href="?controller=user&action=profil">Mon profil</a>
                            <a href="?controller=auth&action=logOut">Déconnexion</a>
                        <?php else: ?>
                            <a href="?controller=auth&action=logIn">Connexion</a>
                            <a href="?controller=user&action=singUp">Inscription</a>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="mobile-menu-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </nav>
        </div>
        <div class="mobile-menu">
            <ul>
                <li><a href="?controller=page&action=accueil">Accueil</a></li>
                <li><a href="?controller=covoiturages&action=showAll">Covoiturages</a></li>
                <li><a href="?controller=page&action=contact">Contact</a></li>
                <li><a href="?controller=page&action=ui">UI</a></li>
                <?php if (Security::islogged()): ?>
                    <?php if (Security::isAdmin()): ?>
                        <li><a href="?controller=admin&action=adminEspace" class="admin-btn">Administration</a></li>
                    <?php endif; ?>
                    <li><a href="?controller=user&action=profil" class="profil-btn">Mon profil</a></li>
                    <li><a href="?controller=auth&action=logOut" class="logout-btn">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="?controller=auth&action=logIn" class="login-btn">Connexion</a></li>
                    <li><a href="?controller=auth&action=register" class="register-btn">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>

<main>
