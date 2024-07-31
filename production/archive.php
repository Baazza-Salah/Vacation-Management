<?php


session_start();


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
    

    $stmt = $pdo->query("SELECT DemandeConge.*, InfoEmployee.Nom AS nomE, InfoEmployee.Prenom AS prenomE
                            FROM DemandeConge
                            JOIN InfoEmployee ON DemandeConge.NumPPR = InfoEmployee.numPPR
                            WHERE DemandeConge.Etat = 'Approved'");


    $archives = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link
      rel="shortcut icon"
      href="images/logo.png"
      type="image/png"
    />

    <title>Archive</title>
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
                        <h3>Approved Demandes <small>List of approved demandes</small></h3>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 ">

                        <div class="col-md-12 col-sm-12 ">
                            <div class="x_panel">
                                <div class="x_title">
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box table-responsive">
                                                <p class="text-muted font-13 m-b-30">
                                                    Below is a list of all approved demandes.
                                                </p>
                                                <table style="text-align: center; justify-content: center;" id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>idDemande</th>
                                                        <th>Employee PPR</th>
                                                        <th>Employee Nom</th>
                                                        <th>Employee Prenom</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Duree</th>
                                                        <th>Type de Conge</th>
                                                        <th>Reason</th>
                                                        <th>print</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($archives as $archive): ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($archive['idDemande']); ?></td>
                                                                <td><?php echo htmlspecialchars($archive['NumPPR']); ?></td>
                                                                <td><?php echo htmlspecialchars($archive['nomE']); ?></td>
                                                                <td><?php echo htmlspecialchars($archive['prenomE']); ?></td>
                                                                <td><?php echo htmlspecialchars($archive['DateDebut']); ?></td>
                                                                <td><?php echo htmlspecialchars($archive['DateFin']); ?></td>
                                                                <td><?php echo htmlspecialchars($archive['Duree']); ?></td>
                                                                <td>
                                                                    <?php if ($archive['idConge'] == 1): ?>
                                                                        <p>Administrative</p>
                                                                    <?php elseif ($archive['idConge'] == 2): ?>
                                                                        <p>Exceptionnel</p>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($archive['Description']); ?></td>
                                                                <td>
                                                                    <?php if ($archive['idConge'] == 1): ?>
                                                                        <a href='printDemandeAdmin.php?id=<?php echo $archive['idDemande']; ?>' class='btn btn-round btn-default btn-xs'><i class='fa fa-print '></i></a>
                                                                    <?php elseif ($archive['idConge'] == 2): ?>
                                                                        <a href='printDemandeExcep.php?id=<?php echo $archive['idDemande']; ?>' class='btn btn-round btn-default btn-xs'><i class='fa fa-print '></i></a>
                                                                    <?php endif; ?>
                                                                </td>

                                                                
                                                            </tr>
                                                        <?php endforeach; ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
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
<script src="../vendors/iCheck/icheck.min.js"></script>
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
<script src="../build/js/custom.min.js"></script>

</body>
</html>
