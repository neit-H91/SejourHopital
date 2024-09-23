Projet de Gestion de Séjours Hospitaliers
Description

Ce projet est une application web développée en Symfony, permettant au personnel médical de gérer les séjours des patients au sein d'un hôpital. L'application offre des fonctionnalités pour visualiser, gérer et valider les séjours des patients dans différents services hospitaliers. Elle propose également un système d'authentification pour sécuriser l'accès.
Fonctionnalités principales
Gestion des Séjours

    Affichage des séjours en cours dans un service spécifique.
    Validation de la sortie d'un patient après la fin de son séjour.
    Recherche des séjours par date dans un service hospitalier.
    Affichage des séjours à venir pour une meilleure anticipation.

Gestion des Utilisateurs

    Affichage de la liste des utilisateurs du système.
    Ajout, modification et suppression d'utilisateurs avec des droits spécifiques.

Authentification

    Connexion sécurisée via un formulaire de login.
    Déconnexion de l'utilisateur.

Prérequis

Avant de démarrer, assurez-vous d'avoir installé les éléments suivants :

    PHP 7.4 ou version supérieure
    Composer
    MySQL
    Symfony CLI (optionnel mais recommandé)

Installation

    Clonez ce dépôt sur votre machine locale :

git clone https://github.com/votre-nom-d-utilisateur/projet-gestion-sejours.git
cd projet-gestion-sejours

Installez les dépendances du projet :

composer install

Configurez votre base de données dans le fichier .env :

DATABASE_URL="mysql://root:password@127.0.0.1:3306/nom_de_votre_base"

Créez la base de données et exécutez les migrations :

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

Démarrez le serveur local :

    symfony server:start

    Accédez à l'application via votre navigateur à l'adresse : http://localhost:8000

Structure du Projet

    src/ : Contient le code source de l'application.
        Controller/ : Les contrôleurs qui gèrent les différentes routes et interactions.
        Entity/ : Les entités Doctrine représentant les modèles de données.
        Form/ : Les classes de formulaires pour la gestion des formulaires HTML.
        Repository/ : Les classes de dépôt pour interagir avec la base de données.
    templates/ : Contient les fichiers Twig utilisés pour afficher les vues (interfaces).
    config/ : Les fichiers de configuration de l'application.
    public/ : Le point d'entrée public de l'application (fichiers CSS, JS, images, index.php).

Architecture

L'application suit une architecture MVC (Modèle-Vue-Contrôleur) :

    Modèles : Les entités Doctrine pour la gestion des données.
    Vues : Gérées par le moteur de templates Twig.
    Contrôleurs : Contiennent la logique métier et orchestrent l'affichage des vues.

Routes Principales

    Accueil : / (Affichage de la page d'accueil avec la date actuelle).
    Séjours :
        /sejour/sorties : Liste des séjours en cours dans un service.
        /sejour/sortie/{id} : Validation de la sortie d'un patient.
        /sejour/date : Recherche des séjours à une date donnée.
        /sejour/aVenir : Liste des séjours à venir.
        /sejour/{id} : Affichage détaillé d'un séjour.
    Utilisateurs :
        /user : Liste des utilisateurs.
        /user/new : Ajout d'un nouvel utilisateur.
        /user/{id} : Affichage ou modification d'un utilisateur.
        /user/{id}/delete : Suppression d'un utilisateur.
    Authentification :
        /login : Connexion des utilisateurs.
        /logout : Déconnexion des utilisateurs.

Technologies Utilisées

    Framework : Symfony 5
    Base de données : MySQL
    Langages : PHP, Twig, HTML, CSS
    ORM : Doctrine
    Pagination : KnpPaginatorBundle
    Authentification : Symfony Security Component
