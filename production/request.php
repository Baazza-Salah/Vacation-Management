<?php
// request.php

// Database connection
$dsn = 'mysql:host=localhost;dbname=GestionConge;charset=utf8mb4';
$username = 'root'; // change to your database username
$password = ''; // change to your database password

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $cnie = htmlspecialchars($_POST['cnie']);
    $Duree = (int)$_POST['Duree'];
    $DateDebut = htmlspecialchars($_POST['DateDebut']);
    $DateFin = htmlspecialchars($_POST['DateFin']);
    $Description = htmlspecialchars($_POST['Description']);
    $idConge = (int)$_POST['idConge'];

    // Check if CNIE exists and get NumPPR
    $stmt = $pdo->prepare("SELECT numPPR FROM InfoEmployee WHERE cnie = ?");
    $stmt->execute([$cnie]);
    $numPPR = $stmt->fetchColumn();

    if (!$numPPR) {
        $errorMessage = "CNIE does not exist in the database.";
    } else {
        // Insert into DemandeConge
        $stmt = $pdo->prepare("INSERT INTO DemandeConge (Duree, DateDebut, DateFin, Description, Etat, NumPPR, idConge) VALUES (?, ?, ?, ?, 'Pending', ?, ?)");
        $stmt->execute([$Duree, $DateDebut, $DateFin, $Description, $numPPR, $idConge]);

        $idDemande = $pdo->lastInsertId();
        $successMessage = "Request Number: N:$idDemande";
        
        // Redirect to avoid resubmitting form data
        header("Location: request.php?successMessage=" . urlencode($successMessage));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Request Leave</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="shortcut icon" href="images/logo.png" type="image/png" />
</head>
<body>
    <!-- Header -->
    <header class="header-area">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="index.html">
                    <img src="images/logo.png" style="width:60px;" alt="Logo" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!-- End Header -->

    <!-- Leave Request Form -->
    <div class="container mt-5">
        <h3 class="text-center mb-4">Request Leave</h3>
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php elseif (isset($_GET['successMessage'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['successMessage']); ?></div>
        <?php endif; ?>
        <form action="request.php" method="POST">
            <div class="mb-3">
                <label for="cnie" class="form-label">CNIE</label>
                <input type="text" class="form-control" id="cnie" name="cnie" required>
            </div>
            <div class="mb-3">
                <label for="Duree" class="form-label">Duration (days)</label>
                <input type="number" class="form-control" id="Duree" name="Duree" required>
            </div>
            <div class="mb-3">
                <label for="DateDebut" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="DateDebut" name="DateDebut" required>
            </div>
            <div class="mb-3">
                <label for="DateFin" class="form-label">End Date</label>
                <input type="date" class="form-control" id="DateFin" name="DateFin" required>
            </div>
            <div class="mb-3">
                <label for="Description" class="form-label">Description</label>
                <textarea class="form-control" id="Description" name="Description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="idConge" class="form-label">Leave Type</label>
                <select class="form-select" id="idConge" name="idConge" required>
                    <option value="">Select Leave Type</option>
                    <option value="1">Administrative</option>
                    <option value="2">Exceptional</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <!-- End Leave Request Form -->

    <footer id="footer" class="footer-area pt-120">
        <div class="container">

        <br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div class="footer-widget pb-100">
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-sm-8" style="justify-content: center; text-align: center;">
                        <div class="footer-about mt-50 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                            <a class="logo" href="javascript:void(0)">
                                <img src="images/logo.png" alt="logo" />
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-7 col-sm-12">
                        <div class="footer-link d-flex mt-50 justify-content-sm-between">
                            <div class="link-wrapper wow fadeIn" data-wow-duration="1s" data-wow-delay="0.4s">
                                <div class="footer-title">
                                    <h4 class="title">Quick Link</h4>
                                </div>
                                <ul class="link">
                                    <li><a href="javascript:void(0)">Ministre link</a></li>
                                    <li><a href="javascript:void(0)">Ministre link</a></li>
                                    <li><a href="javascript:void(0)">Ministre link</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5 col-sm-12">
                        <div class="footer-contact mt-50 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.8s">
                            <div class="footer-title">
                                <h4 class="title">Contact Us</h4>
                            </div>
                            <ul class="contact">
                                <li>+212 676767676</li>
                                <li>province@gmail.com</li>
                                <li>www.web.com</li>
                                <li>35100 Guercif, Maroc</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="row" style="justify-content: center; text-align: center;">
                    <div class="col-lg-12" style="justify-content: center; text-align: center;">
                        <div class="copyright d-sm-flex justify-content-between" style="justify-content: center; text-align: center;">
                            <div class="copyright-content">
                                <p class="text">2024 @ Province de Guercif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="particles-2"></div>
    </footer>
    <a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>
    
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/glightbox.min.js"></script>
    <script src="assets/js/count-up.min.js"></script>
    <script src="assets/js/particles.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
