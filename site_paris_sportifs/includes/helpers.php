<?php

    //fichier qui contient des fonctions php que l'on veut delocaliser
    //notamment quand elles utilisent des valeurs qui doivent etre configuer au moment du test
    //ça évite de devoir chercher dans le code où changer le port du serveur par exemple
    //ces valeurs sont stockées dans /includes/config.php

    //on va chercher la config
    require_once('includes/config.php');

    function openDB() {
        $pdo = new PDO('mysql:host='.$GLOBALS['addr'].';dbname='.$GLOBALS['dbName'], $GLOBALS['MySQLusername'], $GLOBALS['MySQLpwd']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    function checkAdmin () {
        if ($_SESSION["user"]["isAdmin"] != 1) {
        header("Location: /site_paris_sportifs/401");
        exit();
        }
    }

    // calcul des cotes de tous les matchs
    function calcOdds () {
        
        $pdo = openDB();
        $stmt = $pdo->prepare("SELECT * FROM Games");
        $stmt->execute();
        $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($games as $game) {

            // récupération des valeurs totales

            $stmt = $pdo->prepare("SELECT SUM(Amount) AS TotalAmount FROM Bets WHERE GameID=?");
            $stmt->execute([$game['ID']]);
            $totalAmount = $stmt->fetch();
            $totalAmount = $totalAmount["TotalAmount"]; // somme totale

            $stmt = $pdo->prepare("SELECT SUM(Amount) AS HomeAmount FROM Bets WHERE (GameID=? AND H2H=?)");
            $stmt->execute([$game['ID'], 1]);
            $homeAmount = $stmt->fetch();
            $homeAmount = $homeAmount["HomeAmount"]; // somme des paris pour le domicile

            $stmt = $pdo->prepare("SELECT SUM(Amount) AS DrawAmount FROM Bets WHERE (GameID=? AND H2H=?)");
            $stmt->execute([$game['ID'], 0]);
            $drawAmount = $stmt->fetch();
            $drawAmount = $drawAmount["DrawAmount"]; // somme des paris pour le nul

            $stmt = $pdo->prepare("SELECT SUM(Amount) AS AwayAmount FROM Bets WHERE (GameID=? AND H2H=?)");
            $stmt->execute([$game['ID'], 2]);
            $awayAmount = $stmt->fetch();
            $awayAmount = $awayAmount["AwayAmount"]; // somme des paris pour l'exterieur

            // correction des divisions par 0 et des cotes nulles

            if ($homeAmount == 0) {
                $homeAmount = 1;
            }
            if ($drawAmount == 0) {
                $drawAmount = 1;
            }
            if ($awayAmount == 0) {
                $awayAmount = 1;
            }
            if ($totalAmount == 0) {
                $totalAmount = 3;
            }

            // calcul des cotes

            $homeDynaOdd = $totalAmount / $homeAmount;
            $drawDynaOdd = $totalAmount / $drawAmount;
            $awayDynaOdd = $totalAmount / $awayAmount;

            // mise à jour dans la DB

            $stmt = $pdo->prepare("UPDATE Games SET HomeDynaOdd=?, DrawDynaOdd=?, AwayDynaOdd=? WHERE ID=?");
            $stmt->execute([$homeDynaOdd, $drawDynaOdd, $awayDynaOdd, $game["ID"]]);
        }
    }

    //validation des paris et redistributions des gains
    function procWinnings ($gameID) {
        $pdo = openDB();

        $stmt = $pdo->prepare("SELECT * FROM Games WHERE ID=?");
        $stmt->execute([$gameID]);
        $game = $stmt->fetch();
        $H2H = $game['H2H'];

        $stmt = $pdo->prepare("SELECT * FROM Bets WHERE (GameID=? AND H2H=?)");
        $stmt->execute([$gameID, $H2H]);
        $bets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($H2H == 1) {
            $odd = $game['HomeDynaOdd'];
        } elseif ($H2H == 0) {
            $odd = $game['DrawDynaOdd'];
        } elseif ($H2H == 2) {
            $odd = $game['AwayDynaOdd'];
        } else {
            exit();
        }

        foreach ($bets as $bet) {
            $winning = round($bet['Amount'] * $odd);
            $betUser = $bet['UserID'];
            $stmt = $pdo->prepare('UPDATE Wallets SET Balance = Balance + ? WHERE UserID=?');
            $stmt->execute([$winning, $betUser]);
        }

        $stmt = $pdo->prepare('DELETE FROM Bets WHERE GameID=?');
        $stmt->execute([$gameID]);
    }

?>