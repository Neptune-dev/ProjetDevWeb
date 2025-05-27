CREATE DATABASE SiteParis;
USE SiteParis;

/* table des utilisateurs */
CREATE TABLE Users (
  ID int NOT NULL AUTO_INCREMENT,
  FirstName varchar(255) NOT NULL,
  LastName varchar(255) NOT NULL,
  Username varchar(50) NOT NULL,
  Email varchar(255),
  Birthdate DATE NOT NULL,
  Pwd varchar(255) NOT NULL,
  isAdmin bool NOT NULL,
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

/* table des matchs */
CREATE TABLE Games (
  ID int NOT NULL AUTO_INCREMENT,
  Home varchar(255) NOT NULL,
  Away varchar(255) NOT NULL,
  GameDate DATE NOT NULL,
  isLive bool NOT NULL,
  H2H int,
  HomeScore int,
  AwayScore int,
  PRIMARY KEY (ID)
);


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
