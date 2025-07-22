SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Structure de la table `Commentaire`
--

CREATE TABLE `Commentaire` (
  `id` int(10) UNSIGNED NOT NULL,
  `commentaire` varchar(250) NOT NULL,
  `user_covoiturage_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Commentaire`
--

INSERT INTO `Commentaire` (`id`, `commentaire`, `user_covoiturage_id`) VALUES
(4, 'Voici un test comme quoi cette partie fonctionne, test 2', 24),
(5, 'Le conducteur a utilisé son téléphone pendant le trajet.', 84);

-- --------------------------------------------------------

--
-- Structure de la table `Covoiturage`
--

CREATE TABLE `Covoiturage` (
  `id` int(10) UNSIGNED NOT NULL,
  `nb_place_disponible` int(11) NOT NULL,
  `prix` float NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `date_heure_arrivee` datetime NOT NULL,
  `adresse_depart` varchar(255) NOT NULL,
  `adresse_arrivee` varchar(255) NOT NULL,
  `voiture_id` int(10) UNSIGNED DEFAULT NULL,
  `statut_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Covoiturage`
--

-- --------------------------------------------------------

--
-- Structure de la table `Energie`
--

CREATE TABLE `Energie` (
  `id` int(10) UNSIGNED NOT NULL,
  `libelle` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Energie`
--

INSERT INTO `Energie` (`id`, `libelle`) VALUES
(1, 'Électrique'),
(2, 'Hybride'),
(3, 'Diesel - Gazole'),
(4, 'Essence'),
(5, 'GPL');

-- --------------------------------------------------------

--
-- Structure de la table `Preference`
--

CREATE TABLE `Preference` (
  `id` int(10) UNSIGNED NOT NULL,
  `libelle` varchar(500) NOT NULL,
  `statut` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Preference`
--

INSERT INTO `Preference` (`id`, `libelle`, `statut`) VALUES
(1, 'Fumeur', 1),
(2, 'Animal', 1),
(3, 'Non_fumeur', 0),
(4, 'Non_animal', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Role`
--

CREATE TABLE `Role` (
  `id` int(10) UNSIGNED NOT NULL,
  `libelle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Role`
--

INSERT INTO `Role` (`id`, `libelle`) VALUES
(1, 'Passager'),
(2, 'Chauffuer'),
(3, 'Chauffuer - Passager'),
(4, 'Employé'),
(5, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `Statut`
--

CREATE TABLE `Statut` (
  `id` int(10) UNSIGNED NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Statut`
--

INSERT INTO `Statut` (`id`, `libelle`) VALUES
(1, 'Crée'),
(2, 'Démarré'),
(3, 'Arrivé'),
(4, 'Validé'),
(5, 'Annulé');

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `id` int(10) UNSIGNED NOT NULL,
  `nb_credits` int(11) DEFAULT 20,
  `pseudo` varchar(50) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `role_id` int(10) UNSIGNED DEFAULT NULL,
  `photo_uniqId` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `User`

-- --------------------------------------------------------

--
-- Structure de la table `User_Covoiturages`
--

CREATE TABLE `User_Covoiturages` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `covoiturage_id` int(10) UNSIGNED DEFAULT NULL,
  `statut_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `User_Covoiturages`
--


-- --------------------------------------------------------

--
-- Structure de la table `User_Preferences`
--

CREATE TABLE `User_Preferences` (
  `id` int(10) UNSIGNED NOT NULL,
  `preference_personnelle` varchar(500) DEFAULT NULL,
  `preference_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `User_Preferences`
--


-- --------------------------------------------------------

--
-- Structure de la table `Voiture`
--

CREATE TABLE `Voiture` (
  `id` int(10) UNSIGNED NOT NULL,
  `modele` varchar(255) NOT NULL,
  `couleur` varchar(50) NOT NULL,
  `marque` varchar(50) NOT NULL,
  `immatriculation` varchar(50) NOT NULL,
  `date_premiere_immatriculation` date NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `energie_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_covoiturage_id` (`user_covoiturage_id`);

--
-- Index pour la table `Covoiturage`
--
ALTER TABLE `Covoiturage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voiture_id` (`voiture_id`),
  ADD KEY `statut_id` (`statut_id`);

--
-- Index pour la table `Energie`
--
ALTER TABLE `Energie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Preference`
--
ALTER TABLE `Preference`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Statut`
--
ALTER TABLE `Statut`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Index pour la table `User_Covoiturages`
--
ALTER TABLE `User_Covoiturages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_covoiturages_ibfk_2` (`covoiturage_id`),
  ADD KEY `statut_id` (`statut_id`);

--
-- Index pour la table `User_Preferences`
--
ALTER TABLE `User_Preferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `preference_id` (`preference_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `Voiture`
--
ALTER TABLE `Voiture`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Covoiturage`
--
ALTER TABLE `Covoiturage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `Energie`
--
ALTER TABLE `Energie`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Preference`
--
ALTER TABLE `Preference`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Role`
--
ALTER TABLE `Role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Statut`
--
ALTER TABLE `Statut`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT pour la table `User_Covoiturages`
--
ALTER TABLE `User_Covoiturages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT pour la table `User_Preferences`
--
ALTER TABLE `User_Preferences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `Voiture`
--
ALTER TABLE `Voiture`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`user_covoiturage_id`) REFERENCES `User_Covoiturages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Covoiturage`
--
ALTER TABLE `Covoiturage`
  ADD CONSTRAINT `covoiturage_ibfk_1` FOREIGN KEY (`voiture_id`) REFERENCES `Voiture` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `covoiturage_ibfk_2` FOREIGN KEY (`statut_id`) REFERENCES `Statut` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `Role` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `User_Covoiturages`
--
ALTER TABLE `User_Covoiturages`
  ADD CONSTRAINT `user_covoiturages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_covoiturages_ibfk_2` FOREIGN KEY (`covoiturage_id`) REFERENCES `Covoiturage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_covoiturages_ibfk_3` FOREIGN KEY (`statut_id`) REFERENCES `Statut` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `User_Preferences`
--
ALTER TABLE `User_Preferences`
  ADD CONSTRAINT `user_preferences_ibfk_1` FOREIGN KEY (`preference_id`) REFERENCES `Preference` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_preferences_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE;

