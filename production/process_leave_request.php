<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'GestionConge';
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// Secure data from XSS
function clean_input($data) {
    return htmlspecialchars(strip_tags($data));
}

$CNIE = clean_input($_POST['CNIE']);
$Duree = clean_input($_POST['Duree']);
$DateDebut = clean_input($_POST['DateDebut']);
$DateFin = clean_input($_POST['DateFin']);
$Description = clean_input($_POST['Description']);
$idConge = clean_input($_POST['idConge']);

// Check if CNIE exists
$stmt = $pdo->prepare("SELECT COUNT(*) FROM InfoEmployee WHERE cnie = ?");
$stmt->execute([$CNIE]);
$exists = $stmt->fetchColumn();

if ($exists == 0) {
    echo "<script>alert('Error: CNIE does not exist in the database.'); window.location.href='request.php';</script>";
    exit();
}

// Insert leave request into database
$stmt = $pdo->prepare("INSERT INTO DemandeConge (cnie, duree, dateDebut, dateFin, Description, idConge) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$CNIE, $Duree, $DateDebut, $DateFin, $Description, $idConge]);

$idDemande = $pdo->lastInsertId();
echo "<script>alert('Request Number : N:{$idDemande}'); window.location.href='request.php';</script>";
?>
