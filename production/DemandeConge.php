<?php


session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
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
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

// Demande Conge data
$query = "SELECT DemandeConge.*, InfoEmployee.Nom AS nomE, InfoEmployee.Prenom AS prenomE
        FROM DemandeConge
        JOIN InfoEmployee ON DemandeConge.NumPPR = InfoEmployee.numPPR
        WHERE DemandeConge.Etat = 'pending' ";
$stmt = $pdo->query($query);
$demandeConge = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link
      rel="shortcut icon"
      href="images/logo.png"
      type="image/png"
    />

    <title>Demande Conge</title>
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
                <h3>Demande Conges </h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Demandes</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <!-- start project list -->
                    <table style="text-align: center; justify-content: center;" class="table table-striped projects">
                      <thead>
                        <tr>
                          <th style="width: 10%">ID Demande</th>
                          <th>NumPPR</th>
                          <th>Employee Name</th>
                          <th>Employee Lastname</th>
                          <th>Duration</th>
                          <th>Start date</th>
                          <th>End date</th>
                          <th>Type de Conge</th>
                          <th>Reason</th>
                          <th>Status</th>
                          <th><i>Choice</i></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($demandeConge as $demande): ?>
                          <tr>
                            <td><?php echo htmlspecialchars($demande['idDemande']); ?></td>
                            <td><p><?php echo htmlspecialchars($demande['NumPPR']); ?></p></td>
                            <td><p><?php echo htmlspecialchars($demande['prenomE']); ?></p></td>
                            <td><p><?php echo htmlspecialchars($demande['nomE']); ?></p></td>
                            <td><p><?php echo htmlspecialchars($demande['Duree']); ?></p></td>
                            <td><p><?php echo htmlspecialchars($demande['DateDebut']); ?></p></td>
                            <td><p><?php echo htmlspecialchars($demande['DateFin']); ?></p></td>
                            <td>
                              <?php if ($demande['idConge'] == 1): ?>
                                <p>Administrative</p>
                              <?php elseif ($demande['idConge'] == 2): ?>
                                <p>Exceptionnel</p>
                              <?php else: ?>
                                <button type="button" class="btn btn-danger">Unknown</button>
                              <?php endif; ?>
                            </td>
                            <td><p><?php echo htmlspecialchars($demande['Description']); ?></p></td>
                            <td>
                              <?php if ($demande['Etat'] == 'Approved'): ?>
                                <button type="button" class="btn btn-round btn-success">Accepted</button>
                              <?php elseif ($demande['Etat'] == 'Rejected'): ?>
                                <button type="button" class="btn btn-round btn-danger">Declined</button>
                              <?php else: ?>
                                <button type="button" class="btn btn-round btn-warning">Pending</button>
                              <?php endif; ?>
                            </td>
                            
                            <td>
                              <form method="post" action="updateDemande.php" style="display: inline-block; margin: 0;">
                                  <input type="hidden" name="idDemande" value="<?php echo htmlspecialchars($demande['idDemande']); ?>">
                                  <button type="submit" name="action" value="accept" class="btn btn-round btn-success btn-xs">
                                      <i class="fa fa-check"></i>
                                  </button>
                              </form>
                              <form method="post" action="updateDemande.php" style="display: inline-block; margin: 0;">
                                  <input type="hidden" name="idDemande" value="<?php echo htmlspecialchars($demande['idDemande']); ?>">
                                  <button type="submit" name="action" value="reject" class="btn btn-round btn-danger btn-xs">
                                      <i class="fa fa-times"></i>
                                  </button>
                              </form>
                            </td>


                          </tr>
                        <?php endforeach; ?>
                      </tbody>

                    </table>
                    <!-- end project list -->
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
                    2024 @ Province de Guercif --<small> Developped and secured By BAAZZA SALAHEDDINE</small>
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
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="../build/js/custom.min.js"></script>
  </body>
</html>