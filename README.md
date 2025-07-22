# 🚘 EcoRide — Application de covoiturage

![PHP](https://img.shields.io/badge/PHP-8.4-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange?logo=mysql)
![MongoDB](https://img.shields.io/badge/MongoDB-NoSQL-green?logo=mongodb)
![Docker](https://img.shields.io/badge/Docker-Ready-blue?logo=docker)


**EcoRide** est une startup française qui veut réduire la pollution liée aux déplacements en encourageant le covoiturage. Sa plateforme en ligne s’adresse à ceux qui veulent voyager de façon plus écologique et économique, tout en faisant un geste pour la planète.

---

## ⚙️ Fonctionnalités de la plateforme

# 🔐 Utilisateurs & Profils

- Inscription / Connexion sécurisée des utilisateurs
- Gestion des profils pour les chauffeurs et passagers
- Personnalisation des préférences pour les chauffeurs

# 🚗 Trajets & Réservations

- Création de trajets en covoiturage
- Recherche avancée avec filtres personnalisés
- Validation de réservation par les passagers

# ⭐ Interactions & Évaluations

- Système de notes et d’avis après chaque trajet
- Alertes interactives via (SweetAlert)
- Notifications par email avec (PHPMailer)

# 🛠️ Interfaces de gestion

- Interface Employé : modération des trajets et avis
- Interface Administrateur : gestion des comptes utilisateurs et visualisation de statistiques dynamiques

# 🗃️ Technologies de stockage

- Base de données hybride : MySQL (relationnel) & MongoDB (NoSQL)

---

## 🛠️ Technologies utilisées

- HTML, CSS (Sass & Bootstrap 5.3), JavaScript
- PHP 8.4.5 (sans framework)
- MySQL & MongoDB
- PHPMailer pour les envois de mails
- SweetAlert pour les messages utilisateurs
- DataTables (JavaScript Bibliothèque)
- Chart JS (JavaScript Bibliothèque)
- Composer
- NPM

---

## 📦 Prérequis

- **PHP >= 8.1**
- **Serveur web local** (ex. : [XAMPP](https://www.apachefriends.org/), [MAMP](https://www.mamp.info/))
- **Docker** ([Installer Docker](https://www.docker.com/products/docker-desktop/))
- **MySQL** ([Windows](https://dev.mysql.com/downloads/installer/) | [macOS](https://formulae.brew.sh/formula/mysql))
- **MongoDB** ([Windows](https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-windows/) | [macOS](https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-os-x/))

--- 

## 💻 Étapes pour déployer le projet en local

1. **Cloner le dépôt Git :**

    ```bash
    git clone https://github.com/zKiryuuu/Ecoride.git
    ```

2. **Configurer les accès aux bases de données :**

    1. Dans le fichier .env.exemple, adapter vos identifiants MySQL et MongoDB :
        ```dotenv
        # === MYSQL ===
        MYSQL_ROOT_PASSWORD=password
        MYSQL_DATABASE=dbname
        MYSQL_USER=user
        MYSQL_PASSWORD=userpassword

        # === MONGODB ===
        MONGO_INITDB_ROOT_USERNAME=userName
        MONGO_INITDB_ROOT_PASSWORD=userPassword
        MONGO_DB_NAME=DBName
        ```

    2. enlevez le .exemple, afin que le fichier soit lisible en tant que variables d'environement
        >🔐 Ne versionnez jamais le fichier `.env` : ajoutez-le dans votre fichier `.gitignore`.
    3. Dans le fichier App/Db/Mongodb.php -> decommentez la ligne 52 avec le string de connexion à Mongodb en local et commentez la ligne 54 avec le string de connexion à Mongodb Atlas. 
    Voici le code attendu :
        ```php
        try {
            // Connection string en LOCAL
            $connectionPath = "mongodb://" . $user . ":" . $password . "@" . $host . ":" . $port . "/" . $dbName;
            // Connection string en mongoDB Atlas
            // $connectionPath = "mongodb+srv://" . $user . ":" . $password . "@" . $host . "/?retryWrites=true&w=majority&appName=" . $dbName;
            // Instance de la classe Client
            $mongo = new Client($connectionPath);
            $db = $mongo->selectDatabase($dbName); // Sélection de la base de données
            // On retourne l'instance de la base de données
            return $db;
        } catch (Exception $e) {
            echo ('Error : ' . $e->getMessage());
            exit;
        }
        ```

3. **Configuration SMTP pour l'envoi d'emails (en local)**

    L'envoi d'e-mails est géré via PHPMailer. Pour tester les envois d'emails en local sans envoyer de véritables courriels, vous pouvez utiliser [Mailtrap](https://mailtrap.io/).

    **Étapes :**

    1. Créez un compte gratuit sur [Mailtrap](https://mailtrap.io/).
    2. Créez une Inbox et récupérez les informations SMTP dans "SMTP Settings" (choisir "PHP Mailer").
    3. Copiez les informations dans votre fichier `.env` :

    ```dotenv
    SMTP_HOST=sandbox.smtp.mailtrap.io
    SMTP_PORT=2525
    SMTP_USER=your_mailtrap_username
    SMTP_PASSWORD=your_mailtrap_password
    SMTP_FROM_NAME=EcoRide
    SMTP_FROM_EMAIL=no-reply@ecoride.dev
    ````
    > 💡 Dans le fichier App/Tools/SendMail.php, assurez-vous d’utiliser le bon port et le bon protocole :
    - Par exemple:
        ```php
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Utilise TLS
        $mail->Port       = 2525;                           // Port utilisé par Mailtrap avec TLS
        ```

4. **Deploiment Docker**
    1. Lancer les conteneurs :
        ```bash
        docker compose up --build -d
        ```
    2. Accéder à l'application via 
        - [http://localhost:80](http://localhost:80)
    
    Vous pouvez maintenant utiliser EcoRide en local !



    