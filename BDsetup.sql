CREATE DATABASE SiteParis;
USE SiteParis;

/* table des utilisateurs */
CREATE TABLE Users (
  ID int NOT NULL AUTO_INCREMENT,
  FirstName varchar(255) NOT NULL,
  LastName varchar(255) NOT NULL,
  Username varchar(50) NOT NULL,
  Bio varchar(255),
  Email varchar(255),
  Birthdate DATE NOT NULL,
  Pwd varchar(255) NOT NULL,
  isAdmin int NOT NULL,
  PRIMARY KEY (ID)
);

/*table des porte-monnaie :
peut-etre à dupliquer si l'on veut différencier les porte-monnaie
en fonction du  bureau de paris (normal, classé, groupe etc*/
CREATE TABLE Wallets (
  ID int NOT NULL AUTO_INCREMENT,
  UserID int NOT NULL,
  Balance int,
  PRIMARY KEY (ID),
  FOREIGN KEY (UserID) REFERENCES Users(ID)
);

/* table des équipes */
CREATE TABLE Teams (
  ID int NOT NULL AUTO_INCREMENT,
  TeamName varchar(255) NOT NULL,
  TeamLogo varchar(255) NOT NULL,
  PRIMARY KEY (ID)
);

/* table des matchs */
CREATE TABLE Games (
  ID int NOT NULL AUTO_INCREMENT,
  League varchar(255) NOT NULL,
  Home int NOT NULL,
  Away int NOT NULL,
  GameDate DATE NOT NULL,
  GameTime TIME NOT NULL,
  isLive int,
  H2H int,
  HomeScore int,
  AwayScore int,
  HomeOdd FLOAT NOT NULL,
  AwayOdd FLOAT NOT NULL,
  FOREIGN KEY (Home) REFERENCES Teams(ID),
  FOREIGN KEY (Away) REFERENCES Teams(ID),
  PRIMARY KEY (ID)
);

/* table des paris */
CREATE TABLE Bets (
  ID int NOT NULL AUTO_INCREMENT,
  UserID int NOT NULL,
  GameID int NOT NULL,
  H2H int NOT NULL,
  Amount int NOT NULL,
  PRIMARY KEY (ID),
  FOREIGN KEY (UserID) REFERENCES Users(ID),
  FOREIGN KEY (GameID) REFERENCES Games(ID)
);

/*-----------------------------------------------------------------------------------*/
/*Remplissage des tables avec des exemples
le pwd hashé est "password" */
INSERT INTO Users (FirstName, LastName, Username, Email, Birthdate, Pwd, isAdmin)
VALUES ("Toto", "Legrand", "DarkTOTO", "toto@server.fr", "2000-05-24", "$2y$10$RpDO0tGPhU77NdrJ7RdDz.StAikvsuK08jDZHVfABZEZGVGEVO3/e", 0);

INSERT INTO Wallets (UserID, Balance)
SELECT ID, 10000
FROM Users
WHERE Username="DarkTOTO";

/* le pwd est 1234 */
INSERT INTO Users (FirstName, LastName, Username, Birthdate, Pwd, isAdmin)
VALUES ("admin", "admin", "admin",  "2000-01-01", "$2y$10$dxFZ3Cv.kyxBGgEG0UfGl..0D66Glj5q5Spr6QQdjRz6ex/jhHRrm", 1);

/* Equipes d'exemples */
INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("PSG", "https://upload.wikimedia.org/wikipedia/fr/thumb/8/86/Paris_Saint-Germain_Logo.svg/2048px-Paris_Saint-Germain_Logo.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("OM", "https://upload.wikimedia.org/wikipedia/fr/thumb/4/43/Logo_Olympique_de_Marseille.svg/1612px-Logo_Olympique_de_Marseille.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("OL", "https://upload.wikimedia.org/wikipedia/fr/thumb/a/a5/Logo_Olympique_Lyonnais_-_2022.svg/1317px-Logo_Olympique_Lyonnais_-_2022.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Monaco", "https://upload.wikimedia.org/wikipedia/fr/thumb/5/58/Logo_AS_Monaco_FC_-_2021.svg/1200px-Logo_AS_Monaco_FC_-_2021.svg.png");

/* matchs d'exemple */
INSERT INTO Games (League, Home, Away, GameDate, GameTime, HomeOdd, AwayOdd)
VALUES (
"Ligue 1",
(SELECT ID FROM Teams WHERE TeamName = "PSG"),
(SELECT ID FROM Teams WHERE TeamName = "OM"),
"2025-06-15",
"20:45:00",
1.5,
2.8);

INSERT INTO Games (League, Home, Away, GameDate, GameTime, HomeOdd, AwayOdd)
VALUES (
"Ligue 1",
(SELECT ID FROM Teams WHERE TeamName = "OL"),
(SELECT ID FROM Teams WHERE TeamName = "Monaco"),
"2025-06-16",
"21:00:00",
1.3,
2.5);