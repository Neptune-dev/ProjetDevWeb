# BETGLORY

Betglory est un site de paris sportifs à monnaie fictive, conçu dans le cadre d'un projet de développement web à l'INSA.

## Prérequis

- PHP 8.x
- MySQL 5.x ou 8.x
- Un serveur web local (XAMPP, WAMP, MAMP, ou `php -S`)

## Installation

1. Clonez ou téléchargez ce dépôt.
2. Importez le script [BDsetup.sql](BDsetup.sql) dans votre base MySQL.
3. Configurez les accès à la base dans [`site_paris_sportifs/includes/config.php`](site_paris_sportifs/includes/config.php).
4. Placez le dossier [site_paris_sportifs](site_paris_sportifs) dans le répertoire d'exécution de votre serveur web.

## Utilisation

- Rendez-vous sur [http://localhost/site_paris_sportifs/](http://localhost/site_paris_sportifs/)
- Identifiants admin par défaut :  
  - **Nom d'utilisateur** : admin  
  - **Mot de passe** : 1234
- Identifiants d'utilisateur d'exemple:
  - **Nom d'utilisateur** : DarkTOTO  
  - **Mot de passe** : password