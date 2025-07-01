# BETGLORY

Betglory est un site de paris sportifs à monnaie fictive, dont la conception a commencé dans le cadre d'un projet de développement web à l'INSA. 

## Prérequis

- Docker 

ou

- PHP 8.x
- MySQL 5.x ou 8.x
- Un serveur web local XAMPP

## Installation

### Avec Docker

1. Clonez ou téléchargez ce dépôt.
2. À la racine du projet, exécutez la commande : `docker-compose up --build`

### Avec XAMPP

1. Clonez ou téléchargez ce dépôt.
2. Importez le script [`db/BDsetup.sql`](db/BDsetup.sql) dans votre base MySQL via phpmyadmin.
3. Configurez les accès à la base dans [`www/site_paris_sportifs/includes/config.php`](www/site_paris_sportifs/includes/config.php).
4. Placez le dossier [site_paris_sportifs](www/site_paris_sportifs) dans le répertoire d'exécution de votre serveur web.

## Utilisation

- Rendez-vous sur [http://localhost/site_paris_sportifs/](http://localhost/site_paris_sportifs/)
- Identifiants admin par défaut :  
  - **Nom d'utilisateur** : admin  
  - **Mot de passe** : 1234
- Identifiants d'utilisateur d'exemple:
  - **Nom d'utilisateur** : DarkTOTO  
  - **Mot de passe** : password
- phpmyadmin est accessible à l'adresse [http://localhost/](http://localhost/)

---

Ce projet est sous licence Creative Commons Attribution : [Licence](LICENSE)