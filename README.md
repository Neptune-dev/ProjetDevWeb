# BETGLORY

Betglory est un site de paris sportifs à monnaie fictive, dont la conception a commencé dans le cadre d'un projet de développement web à l'INSA. 

## Prérequis

- Docker *(recommandé)*

__ou__

- PHP 8.x
- MySQL 5.x ou 8.x
- Un serveur web local XAMPP

## Installation

### Avec Docker *(recommandé)*

Clonez ou téléchargez ce dépôt.

### Avec XAMPP

1. Clonez ou téléchargez ce dépôt.
2. Lancer Apache et MySQL depuis le panneau de contrôle de XAMPP.
3. Importez le script [`db/BDsetup.sql`](db/BDsetup.sql) dans votre base MySQL via phpmyadmin, accessible à l'adresse [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/).
4. Configurez les accès à la base (port, utilisateur et mot de passe) dans le fichier [`www/site_paris_sportifs/includes/config.php`](www/site_paris_sportifs/includes/config.php), selon votre propre configuration de XAMPP.
5. Placez le dossier [site_paris_sportifs](www/site_paris_sportifs) dans le répertoire d'exécution de votre serveur web.

## Utilisation

Pour lancer le serveur :
- **Pour Docker** :
  - Pour lancer en clair, à la racine du projet, exécutez la commande : `docker-compose up --build`
  - Pour lancer en arrière plan, à la racine du projet, exécutez la commande : `docker-compose up --build -d`
- **Pour XAMPP** : Lancer Apache et MySQL depuis le panneau de contrôle de XAMPP.

<br>

Le site est accessible à l'adresse [http://localhost/site_paris_sportifs/](http://localhost/site_paris_sportifs/).

<br>

- Identifiants admin par défaut :  
  - **Nom d'utilisateur** : admin  
  - **Mot de passe** : 1234
- Identifiants d'utilisateur d'exemple:
  - **Nom d'utilisateur** : DarkTOTO  
  - **Mot de passe** : password
- phpmyadmin est accessible à l'adresse:
  - **Pour Docker** : [http://localhost:8080/](http://localhost:8080/)
  - **Pour XAMPP** :[http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)

<br>

- Pour fermer le serveur :
  - **Pour Docker** : À la racine du projet, exécutez la commande : `docker-compose down -v`
  - **Pour XAMPP** : Arretez Apache et MySQL depuis le panneau de contrôle de XAMPP.

---

Ce projet est sous licence Creative Commons Attribution : [Licence](LICENSE)