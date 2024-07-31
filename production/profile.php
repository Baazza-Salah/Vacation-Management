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


    $numPPR = isset($_GET['id']) ? $_GET['id'] : '';

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
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link
      rel="shortcut icon"
      href="images/logo.png"
      type="image/png"
    />

    <title>Profile</title>
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
            <!-- menu profile quick info -->
            <div class="profile clearfix" style="display: flex; justify-content: center; align-items: center;">
              <div class="profile_pic" >
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
                    <a class="dropdown-item"  href="#"> Profile</a>
                    <a class="dropdown-item"  href="#"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
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
                <h3>User Profile</h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>User Report <small>Activity report</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-4 col-sm-3  profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img  class="img-responsive avatar-view" src="images/user.png" alt="Avatar" title="Change the avatar">
                        </div>
                      </div>
                      <h3><?php echo htmlspecialchars($employee['Prenom'] . ' ' . $employee['Nom']); ?></h3>

                        <ul class="list-unstyled user_data" style="font-size: 18px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color: black; background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span><i class="fa fa-bookmark user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> CNIE</span>
                                <span>: <?php echo htmlspecialchars($employee['cnie']); ?></span>
                            </li>
                            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span><i class="fa fa-tag user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> PPR</span>
                                <span>: <?php echo htmlspecialchars($employee['numPPR']); ?></span>
                            </li>
                            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span><i class="fa fa-calendar user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> DATE NAISSANCE</span>
                                <span>: <?php echo htmlspecialchars($employee['DateNaissance']); ?></span>
                            </li>
                            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span><i class="fa fa-calendar user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> DATE AFFECTATION</span>
                                <span>: <?php echo htmlspecialchars($employee['DateEffet']); ?></span>
                            </li>
                            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span><i class="fa fa-sitemap user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> GRADE</span>
                                <span>: <?php echo htmlspecialchars($employee['Grade']); ?></span>
                            </li>
                            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span><i class="fa fa-university user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> AFFECTATION</span>
                                <span>: <?php echo htmlspecialchars($employee['affectation']); ?></span>
                            </li>
                            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span><i class="fa fa-briefcase user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> FONCTION</span>
                                <span>: <?php echo htmlspecialchars($employee['fonction']); ?></span>
                            </li>
                            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span><i class="fa fa-heart user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> SITUATION</span>
                                <span>: <?php echo htmlspecialchars($employee['situationFamiliale']); ?></span>
                            </li>
                            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span><i class="fa fa-bullhorn user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> ECHELON</span>
                                <span>: <?php echo htmlspecialchars($employee['echelon']); ?></span>
                            </li>
                            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span><i class="fa fa-eye user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> GENDER</span>
                                <span>: <?php echo htmlspecialchars($employee['gender']); ?></span>
                            </li>
                            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <span><i class="fa fa-map-marker user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> ADRESSE</span>
                                <span>: <?php echo htmlspecialchars($employee['adresse']); ?></span>
                            </li>
                            <li style="display: flex; justify-content: space-between;">
                                <span><i class="fa fa-calendar user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> JOURS RESTANTS <small>Administrative</small></span>
                                <span>: <?php echo htmlspecialchars($employee['jourRestant']); ?></span>
                            </li>
                            <li style="display: flex; justify-content: space-between;">
                                <span><i class="fa fa-calendar user-profile-icon" style="color: #337ab7; margin-right: 10px;"></i> JOURS RESTANTS <small>Exceptionnel</small></span>
                                <span>: <?php echo htmlspecialchars($employee['jourRestantExcep']); ?></span>
                            </li>
                        </ul>


                      <a  href="editprofile.php?id=<?php echo $employee['numPPR']; ?>" class="btn btn-primary"><i class="fa fa-edit m-right-xs"></i> Edit Profile </a>
                      <br />
                    </div>
                    <div class="col-md-8 col-sm-9 ">
                      <div class="profile_title">
                        <div class="col-md-6">
                          <h2>Deamndes Effectues</h2>
                        </div>
                      </div>
                      <br>

                      <!-- start of user-activity-graph -->
                      <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>IdDemande</th>
                                    <th>Type Conge</th>
                                    <th>Duree</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Reason</th>
                                    <th style="width: 5%"><i>Status</i></th>
                                </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($leaveRequests as $request) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($request['idDemande']); ?></td>
                                    <td>
                                        <?php if ($request['idConge'] == 1): ?>
                                            <p>Administrative</p>
                                        <?php elseif ($request['idConge'] == 2): ?>
                                            <p>Exceptionnel</p>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($request['Duree']); ?></td>
                                    <td><?php echo htmlspecialchars($request['DateDebut']); ?></td>
                                    <td><?php echo htmlspecialchars($request['DateFin']); ?></td>
                                    <td><?php echo htmlspecialchars($request['Description']); ?></td>
                                    <td>
                                        <?php if ($request['Etat'] == 'Approved'): ?>
                                            <button type="button" class="btn btn-round btn-success">Accepted</button>
                                        <?php elseif ($request['Etat'] == 'Rejected'): ?>
                                            <button type="button" class="btn btn-round btn-danger">Declined</button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-round btn-warning">Pending</button>
                                        <?php endif; ?>
                                    </td>
                                    
                                </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- end of user-activity-graph -->

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
            <p class="text" >
                    2024 @ Province de Guercif
                  </p>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

      </div>
    </div>
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <script src="../vendors/nprogress/nprogress.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="../build/js/custom.min.js"></script>
  </body>
</html>
