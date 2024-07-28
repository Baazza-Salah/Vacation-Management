<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Prevent caching of the login page
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Redirect to login page
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

    $idDemande = $_POST['idDemande'];
    $action = $_POST['action'];

    if ($action == 'accept') {

        $stmt = $pdo->prepare("SELECT * FROM DemandeConge WHERE idDemande = :idDemande");
        $stmt->execute([':idDemande' => $idDemande]);
        $demande = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($demande) {
            $numPPR = $demande['NumPPR'];
            $duree = $demande['Duree'];
            $idConge = $demande['idConge'];

            if ($idConge == 1) { 
                $stmt = $pdo->prepare("SELECT jourRestant FROM InfoEmployee WHERE numPPR = :numPPR");
                $stmt->execute([':numPPR' => $numPPR]);
                $employee = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($employee) {
                    $joursRestant = $employee['jourRestant'];

                    if ($joursRestant >= $duree) {

                        $newJoursRestant = $joursRestant - $duree;
                        $stmt = $pdo->prepare("UPDATE InfoEmployee SET jourRestant = :newJoursRestant WHERE numPPR = :numPPR");
                        $stmt->execute([':newJoursRestant' => $newJoursRestant, ':numPPR' => $numPPR]);


                        $newState = 'Approved';
                        $stmt = $pdo->prepare("UPDATE DemandeConge SET Etat = :etat WHERE idDemande = :idDemande");
                        $stmt->execute([':etat' => $newState, ':idDemande' => $idDemande]);


                        header('Location: DemandeConge.php');
                        exit;
                    } else {
                        echo "<script>alert('Not enough days remaining'); window.location.href = 'DemandeConge.php';</script>";
                        exit;
                    }
                } else {
                    throw new Exception('Employee not found');
                }
            }
            
            else if ($idConge == 2) { 
                $stmt = $pdo->prepare("SELECT jourRestantExcep FROM InfoEmployee WHERE numPPR = :numPPR");
                $stmt->execute([':numPPR' => $numPPR]);
                $employee = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($employee) {
                    $jourRestantExcep = $employee['jourRestantExcep'];

                    if ($jourRestantExcep >= $duree) {

                        $newJoursRestant = $jourRestantExcep - $duree;
                        $stmt = $pdo->prepare("UPDATE InfoEmployee SET jourRestantExcep = :newJoursRestant WHERE numPPR = :numPPR");
                        $stmt->execute([':newJoursRestant' => $newJoursRestant, ':numPPR' => $numPPR]);


                        $newState = 'Approved';
                        $stmt = $pdo->prepare("UPDATE DemandeConge SET Etat = :etat WHERE idDemande = :idDemande");
                        $stmt->execute([':etat' => $newState, ':idDemande' => $idDemande]);


                        header('Location: DemandeConge.php');
                        exit;
                    } else {
                        echo "<script>alert('Not enough days remaining'); window.location.href = 'DemandeConge.php';</script>";
                        exit;
                    }
                } else {
                    throw new Exception('Employee not found');
                }

            }
            else {

                $newState = 'Approved';
                $stmt = $pdo->prepare("UPDATE DemandeConge SET Etat = :etat WHERE idDemande = :idDemande");
                $stmt->execute([':etat' => $newState, ':idDemande' => $idDemande]);


                header('Location: DemandeConge.php'); 
                exit;
            }
        } else {
            throw new Exception('Demande not found');
        }
    } elseif ($action == 'reject') {
        $newState = 'Rejected';
        $stmt = $pdo->prepare("UPDATE DemandeConge SET Etat = :etat WHERE idDemande = :idDemande");
        $stmt->execute([':etat' => $newState, ':idDemande' => $idDemande]);

        header('Location: DemandeConge.php');
        exit;
    } else {
        throw new Exception('Invalid action');
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
