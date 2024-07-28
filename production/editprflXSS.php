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

    $numPPR = isset($_GET['id']) ? htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8') : '';

    if (empty($numPPR)) {
        echo "No employee ID provided.";
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM InfoEmployee WHERE numPPR = ?");
    $stmt->execute([$numPPR]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employee) {
        echo "Employee not found.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $pdo->prepare("UPDATE InfoEmployee SET 
                                Prenom = ?, Nom = ?, cnie = ?, DateNaissance = ?, DateEffet = ?, 
                                Grade = ?, affectation = ?, fonction = ?, situationFamiliale = ?, 
                                echelon = ?, gender = ?, adresse = ?, jourRestant = ?, jourRestantExcep = ?
                              WHERE numPPR = ?");
        
        $stmt->execute([
            htmlspecialchars($_POST['Prenom'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['Nom'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['cnie'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['DateNaissance'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['DateEffet'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['Grade'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['affectation'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['fonction'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['situationFamiliale'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['echelon'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['adresse'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['jourRestant'], ENT_QUOTES, 'UTF-8'), 
            htmlspecialchars($_POST['jourRestantExcep'], ENT_QUOTES, 'UTF-8'),
            $numPPR
        ]);

        echo "Profile updated successfully.";
        header("Location: profile.php?id=$numPPR");
        exit;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="../build/css/custom.min.css" rel="stylesheet">

    <title>Edit Profile</title>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        
                    </div>

                    <div class="clearfix"></div>
                    <!-- menu profile quick info -->
                    <div class="profile clearfix" style="display: flex; justify-content: center; align-items: center;">
                        <div class="profile_pic">
                            <a href="dashboard.php"><img src="images/logo.png" style="height: 90px;"></a>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />
                    <br />
                    <br />
                    <br />
                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="dashboard.php"><i class="fa fa-home"></i> Dashboard </a></li>
                                <li><a href="employees.php"><i class="fa fa-sitemap"></i> Employees </a></li>
                                <li><a href="DemandeConge.php"><i class="fa fa-edit"></i> Demandes </a></li>
                                <li><a href="archive.php"><i class="fa fa-table"></i> Archive </a></li>
                                <li><a href="calendar.php"><i class="fa fa-calendar"></i> Calendar </a></li>
                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>Other</h3>
                            <ul class="nav side-menu">
                                <li><a href="#"><i class="fa fa-user"></i> Profile </a></li>
                                <li><a href="logout.php"><i class="fa fa-close"></i> Log out </a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img src="images/user.png" alt="">Admin
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#"> Profile</a>
                                    <a class="dropdown-item" href="#"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Edit Profile</h3>
                        </div>
                    </div>
                    
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Edit Profile <small>Update your information</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                <form action="editprofile.php?id=<?php echo htmlspecialchars($employee['numPPR'], ENT_QUOTES, 'UTF-8'); ?>" method="post" class="form-horizontal form-label-left">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-sm-3 col-xs-12 col-form-label">First Name</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="Prenom" value="<?php echo htmlspecialchars($employee['Prenom'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-sm-3 col-xs-12 col-form-label">Last Name</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="Nom" value="<?php echo htmlspecialchars($employee['Nom'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div
