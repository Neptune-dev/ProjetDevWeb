<?php
session_start();
require_once('../includes/helpers.php');

header('Content-Type: application/json');

if (!isset($_SESSION["user"])) {
    echo json_encode(["success" => false, "message" => "Non connecté"]);
    exit;
}

$pdo = openDB();
$userID = $_SESSION["user"]["ID"];

// Ajouter 200 unités
$stmt = $pdo->prepare("UPDATE Wallets SET Balance = Balance + 200 WHERE UserID = ?");
$stmt->execute([$userID]);

// Renvoyer le nouveau solde
$stmt = $pdo->prepare("SELECT Balance FROM Wallets WHERE UserID = ?");
$stmt->execute([$userID]);
$wallet = $stmt->fetch();

echo json_encode([
    "success" => true,
    "newBalance" => $wallet["Balance"]
]);
