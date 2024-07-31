<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Prevent caching of the login page
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Location: login.php");
    exit;
}



$host = 'localhost';
$dbname = 'GestionConge';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $idDemande = isset($_GET['id']) ? $_GET['id'] : '';

    if (empty($idDemande)) {
        echo "No ID provided.";
        exit;
    }


    $stmt = $pdo->prepare("SELECT * FROM DemandeConge WHERE idDemande = ?");
    $stmt->execute([$idDemande]);
    $demande = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$demande) {
        echo "Demande not found.";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM DemandeConge WHERE numPPR = ?");
    $stmt->execute([$numPPR]);
    $leaveRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>