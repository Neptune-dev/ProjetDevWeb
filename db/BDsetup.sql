CREATE DATABASE SiteParis;
USE SiteParis;

/* table des utilisateurs */
CREATE TABLE Users (
  ID int NOT NULL AUTO_INCREMENT,
  FirstName varchar(255) NOT NULL,
  LastName varchar(255) NOT NULL,
  Username varchar(50) NOT NULL,
  Bio varchar(255),
  Picture varchar(255),
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
  HomeDynaOdd FLOAT NOT NULL,
  DrawDynaOdd FLOAT NOT NULL,
  AwayDynaOdd FLOAT NOT NULL,
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

/* Equipes d'exemples (On a pris celles de la ligue 1*/
INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Paris-SG", "https://upload.wikimedia.org/wikipedia/fr/thumb/8/86/Paris_Saint-Germain_Logo.svg/2048px-Paris_Saint-Germain_Logo.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Marseille", "https://upload.wikimedia.org/wikipedia/fr/thumb/4/43/Logo_Olympique_de_Marseille.svg/1612px-Logo_Olympique_de_Marseille.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Lyon", "https://upload.wikimedia.org/wikipedia/fr/thumb/a/a5/Logo_Olympique_Lyonnais_-_2022.svg/1317px-Logo_Olympique_Lyonnais_-_2022.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Monaco", "https://upload.wikimedia.org/wikipedia/fr/thumb/5/58/Logo_AS_Monaco_FC_-_2021.svg/1200px-Logo_AS_Monaco_FC_-_2021.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Nice", "https://upload.wikimedia.org/wikipedia/fr/thumb/b/b1/Logo_OGC_Nice_2013.svg/1200px-Logo_OGC_Nice_2013.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Lille", "https://upload.wikimedia.org/wikipedia/fr/thumb/6/62/Logo_LOSC_Lille_2018.svg/1200px-Logo_LOSC_Lille_2018.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Strasbourg", "https://upload.wikimedia.org/wikipedia/fr/thumb/7/70/Racing_Club_de_Strasbourg_Alsace_%28RC_Strasbourg_-_RCS_-_RCSA%29_logo_officiel.svg/1200px-Racing_Club_de_Strasbourg_Alsace_%28RC_Strasbourg_-_RCS_-_RCSA%29_logo_officiel.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Lens", "https://upload.wikimedia.org/wikipedia/fr/thumb/c/c5/Logo_RC_Lens.svg/1200px-Logo_RC_Lens.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Brest", "https://upload.wikimedia.org/wikipedia/fr/thumb/1/14/Logo_Stade_Brestois.svg/1200px-Logo_Stade_Brestois.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Toulouse", "https://upload.wikimedia.org/wikipedia/fr/thumb/8/8b/Logo_Toulouse_FC_2018.svg/1200px-Logo_Toulouse_FC_2018.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Auxerre", "https://upload.wikimedia.org/wikipedia/fr/thumb/f/f6/Logo_AJ_Auxerre_2024.svg/langfr-250px-Logo_AJ_Auxerre_2024.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Rennes", "https://upload.wikimedia.org/wikipedia/fr/thumb/e/e9/Logo_Stade_Rennais_FC.svg/1200px-Logo_Stade_Rennais_FC.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Nantes", "https://upload.wikimedia.org/wikipedia/commons/thumb/4/45/Logo_FC_Nantes_%28avec_fond%29_-_2019.svg/1200px-Logo_FC_Nantes_%28avec_fond%29_-_2019.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Angers", "https://upload.wikimedia.org/wikipedia/fr/thumb/d/d3/Logo_Angers_SCO_-_2021.svg/1720px-Logo_Angers_SCO_-_2021.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Le Havre", "https://upload.wikimedia.org/wikipedia/fr/thumb/e/e6/Logo_Havre_AC_2012.svg/1200px-Logo_Havre_AC_2012.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Reims", "https://upload.wikimedia.org/wikipedia/fr/thumb/a/ad/Logo_Stade_de_Reims_2020_%28Alternatif%29.svg/1200px-Logo_Stade_de_Reims_2020_%28Alternatif%29.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Saint-Etienne", "https://upload.wikimedia.org/wikipedia/fr/thumb/3/3e/AS_Saint-Etienne-logo_2022.svg/1642px-AS_Saint-Etienne-logo_2022.svg.png");

INSERT INTO Teams (TeamName, TeamLogo)
VALUES ("Montpellier", "https://upload.wikimedia.org/wikipedia/commons/6/6a/Logo_-_Montpellier_H%C3%A9rault_Sport_Club_%28MHSC%29.png");


/* matchs d'exemple */
INSERT INTO Games (League, Home, Away, GameDate, GameTime, HomeOdd, AwayOdd, HomeDynaOdd, DrawDynaOdd, AwayDynaOdd)
VALUES (
"Ligue 1",
(SELECT ID FROM Teams WHERE TeamName = "Paris-SG"),
(SELECT ID FROM Teams WHERE TeamName = "Marseille"),
"2025-06-15",
"20:45:00",
1.5,
2.8,
1,1,1);

INSERT INTO Games (League, Home, Away, GameDate, GameTime, HomeOdd, AwayOdd, HomeDynaOdd, DrawDynaOdd, AwayDynaOdd)
VALUES (
"Ligue 1",
(SELECT ID FROM Teams WHERE TeamName = "Lyon"),
(SELECT ID FROM Teams WHERE TeamName = "Monaco"),
"2025-06-16",
"21:00:00",
1.3,
2.5,
1,1,1);