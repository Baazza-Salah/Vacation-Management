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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $cnie = $_POST['cnie'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $situation = $_POST['situation'];
    $ppr = $_POST['ppr'];
    $grade = $_POST['grade'];
    $fonction = $_POST['fonction'];
    $date_affectation = $_POST['date_affectation'];
    $echelon = $_POST['echelon'];
    $adresse = $_POST['adresse'];
    
    // Database connection
    $host = 'localhost';
    $dbname = 'GestionConge';
    $username = 'root';
    $password = '';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO InfoEmployee (numPPR, cnie, Nom, Prenom, DateNaissance, DateEffet, Grade, affectation, fonction, situationFamiliale, echelon, adresse, gender)
                VALUES (:ppr, :cnie, :lastname, :firstname, :dob, :date_affectation, :grade, :date_affectation, :fonction, :situation, :echelon, :adresse, :gender)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':cnie', $cnie);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':situation', $situation);
        $stmt->bindParam(':ppr', $ppr);
        $stmt->bindParam(':grade', $grade);
        $stmt->bindParam(':fonction', $fonction);
        $stmt->bindParam(':date_affectation', $date_affectation);
        $stmt->bindParam(':echelon', $echelon);
        $stmt->bindParam(':adresse', $adresse);
        
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link
      rel="shortcut icon"
      href="images/logo.png"
      type="image/png"
    />
    <title>Add Employee</title>
    <style>
        .left_col {
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }
        
    </style>
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    
                    <div class="navbar nav_title" style="border: 0;">
                        
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="profile clearfix" style="display: flex; justify-content: center; align-items: center;">
                        <div class="profile_pic">
                            <a href="dashboard.php"><img src="images/logo.png" style="height: 90px;"></a>
                        </div>
                    </div>
                    <br /><br /><br /><br /><br />
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
                </div>
            </div>
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
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Add Employee</h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div id="wizard" class="form_wizard wizard_horizontal">
                                        <ul class="wizard_steps">
                                            <li>
                                                <a href="#step-1">
                                                    <span class="step_no">1</span>
                                                    <span class="step_descr">Step 1<br /></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-2">
                                                    <span class="step_no">2</span>
                                                    <span class="step_descr">Step 2<br /></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#step-3">
                                                    <span class="step_no">3</span>
                                                    <span class="step_descr">Step 3<br /></span>
                                                </a>
                                            </li>
                                        </ul>
                                        <form class="form-horizontal form-label-left" action="addemployee.php" method="POST">
                                            <div id="step-1">
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">First Name <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" name="firstname" class="form-control has-feedback-left" placeholder="First Name" required>
                                                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Last Name <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" name="lastname" class="form-control has-feedback-left" placeholder="Last Name" required>
                                                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="cnie">CNIE <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" name="cnie" class="form-control has-feedback-left" placeholder="CNIE" required>
                                                        <span class="fa fa-tag form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="dob">Date of Birth <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="date" name="dob" class="form-control has-feedback-left" required>
                                                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="gender">Gender <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <select name="gender" class="form-control has-feedback-left" required>
                                                            <option value="">Choose option</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="situation">Family Situation <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <select name="situation" class="form-control has-feedback-left" required>
                                                            <option value="">Choose option</option>
                                                            <option value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                        </select>
                                                        <span class="fa fa-users form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="step-2">
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="ppr">PPR <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" name="ppr" class="form-control has-feedback-left" placeholder="PPR" required>
                                                        <span class="fa fa-tag form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="grade">Grade <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" name="grade" class="form-control has-feedback-left" placeholder="Grade" required>
                                                        <span class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="fonction">Function <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" name="fonction" class="form-control has-feedback-left" placeholder="Function" required>
                                                        <span class="fa fa-briefcase form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="date_affectation">Date of Effect <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="date" name="date_affectation" class="form-control has-feedback-left" required>
                                                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="echelon">Echelon <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" name="echelon" class="form-control has-feedback-left" placeholder="Echelon" required>
                                                        <span class="fa fa-level-up form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="step-3">
                                                <div class="form-group row">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="adresse">Address <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" name="adresse" class="form-control has-feedback-left" placeholder="Address" required>
                                                        <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="ln_solid"></div>
                                                <div class="form-group row">
                                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer content -->
                <footer>
            <div class="pull-right">
            <p class="text" >
                    2024 @ Province de Guercif --<small> Developped and secured By BAAZZA SALAHEDDINE</small>
                  </p>
            </div>
            <div class="clearfix"></div>
        </footer>
                <!-- /footer content -->
            </div>
        </div>
    </div>
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <script src="../vendors/nprogress/nprogress.js"></script>
    <script src="../vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <script src="../build/js/custom.min.js"></script>
</body>
</html>
