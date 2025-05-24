CREATE DATABASE SiteParis;
USE SiteParis;

/* table des utilisateurs */
CREATE TABLE Users (
  ID int NOT NULL AUTO_INCREMENT,
  FirstName varchar(255) NOT NULL,
  LastName varchar(255) NOT NULL,
  Username varchar(50) NOT NULL,
  Email varchar(255),
  Age int NOT NULL,
  Pwd varchar(255) NOT NULL,
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

/*Remplissage des tables avec des exemples
le pwd hashé est "password" */
INSERT INTO Users (FirstName, LastName, Username, Email, Age, Pwd)
VALUES ("Toto", "Legrand", "DarkTOTO", "toto@server.fr", 20, "$2y$10$RpDO0tGPhU77NdrJ7RdDz.StAikvsuK08jDZHVfABZEZGVGEVO3/e");

INSERT INTO Wallets (UserID, Balance)
SELECT ID, 10000
FROM Users
WHERE Username="DarkTOTO";