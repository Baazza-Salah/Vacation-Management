<?php
session_start();

// Check if the admin is logged in
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

    $adminPPR = $_SESSION['adminPPR'];

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cnie = $_POST['cnie'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];

        $update_stmt = $pdo->prepare("UPDATE admin SET cnie = ?, email = ?, username = ?, nom = ?, prenom = ? WHERE adminPPR = ?");
        $update_stmt->execute([$cnie, $email, $username, $nom, $prenom, $adminPPR]);

        header("Location: profileadmin.php");
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE adminPPR = ?");
    $stmt->execute([$adminPPR]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        echo "Admin not found.";
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
    <link rel="shortcut icon" href="images/logo.png" type="image/png">
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
            <div class="navbar nav_title" style="border: 0;"></div>
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
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-4 col-sm-3  profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <img class="img-responsive avatar-view" src="images/user.png" alt="Avatar" title="Change the avatar">
                        </div>
                      </div>
                      <h3><?php echo htmlspecialchars($admin['prenom'] . ' ' . $admin['nom']); ?></h3>
                      <ul class="list-unstyled user_data">
                        <li>
                          <i class="fa fa-bookmark user-profile-icon"></i> CNIE: <?php echo htmlspecialchars($admin['cnie']); ?>
                        </li>
                        <li>
                          <i class="fa fa-tag user-profile-icon"></i> PPR: <?php echo htmlspecialchars($admin['adminPPR']); ?>
                        </li>
                        <li>
                          <i class="fa fa-envelope user-profile-icon"></i> Email: <?php echo htmlspecialchars($admin['email']); ?>
                        </li>
                        <li>
                          <i class="fa fa-user user-profile-icon"></i> Username: <?php echo htmlspecialchars($admin['username']); ?>
                        </li>
                      </ul>
                      <button class="btn btn-primary" data-toggle="collapse" data-target="#editProfileForm"><i class="fa fa-edit m-right-xs"></i> Edit Profile </button>
                      <br />
                      <div id="editProfileForm" class="collapse">
                        <form action="profileadmin.php" method="post">
                          <div class="form-group">
                            <label for="cnie">CNIE</label>
                            <input type="text" class="form-control" id="cnie" name="cnie" value="<?php echo htmlspecialchars($admin['cnie']); ?>">
                          </div>
                          <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>">
                          </div>
                          <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>">
                          </div>
                          <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($admin['nom']); ?>">
                          </div>
                          <div class="form-group">
                            <label for="prenom">Prenom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($admin['prenom']); ?>">
                          </div>
                          <button type="submit" class="btn btn-success">Save Changes</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <footer>
            <div class="pull-right">
                <p class="text">
                    2024 @ Province de Guercif
                </p>
            </div>
            <div class="clearfix"></div>
        </footer>
      </div>
    </div>
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <script src="../vendors/nprogress/nprogress.js"></script>
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
    <script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <script src="../vendors/switchery/dist/switchery.min.js"></script>
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
    <script src="../vendors/autosize/dist/autosize.min.js"></script>
    <script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <script src="../vendors/starrr/dist/starrr.js"></script>
    <script src="../build/js/custom.min.js"></script>
  </body>
</html>
