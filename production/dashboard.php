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

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Total employees
$total_employees_query = "SELECT COUNT(*) FROM InfoEmployee";
$result = $conn->query($total_employees_query);
$total_employees = $result->fetch_array()[0];

// Male employees
$male_employees_query = "SELECT COUNT(*) FROM InfoEmployee WHERE gender = 'Male'";
$result = $conn->query($male_employees_query);
$male_employees = $result->fetch_array()[0];

// Female employees
$female_employees_query = "SELECT COUNT(*) FROM InfoEmployee WHERE gender = 'Female'";
$result = $conn->query($female_employees_query);
$female_employees = $result->fetch_array()[0];

// Married employees
$married_employees_query = "SELECT COUNT(*) FROM InfoEmployee WHERE situationFamiliale = 'Married'";
$result = $conn->query($married_employees_query);
$married_employees = $result->fetch_array()[0];

// Single employees
$single_employees_query = "SELECT COUNT(*) FROM InfoEmployee WHERE situationFamiliale = 'Single'";
$result = $conn->query($single_employees_query);
$single_employees = $result->fetch_array()[0];

// Fetch data for charts
// Leave Status
$sql1 = "SELECT Etat, COUNT(*) as count FROM DemandeConge GROUP BY Etat";
$result1 = $conn->query($sql1);
$leaveStatusData = [];
while($row = $result1->fetch_assoc()) {
    $leaveStatusData[] = $row;
}

$sql11 = "SELECT Etat, COUNT(*) as count FROM DemandeConge GROUP BY Etat";
$result11 = $conn->query($sql11);
$leaveStatusDData = [];
while($row = $result11->fetch_assoc()) {
    $leaveStatusDData[] = $row;
}

// Leave Type Distribution
$sql2 = "SELECT t.intitule, COUNT(*) as count 
         FROM DemandeConge d 
         JOIN TypeConge t ON d.idConge = t.idConge 
         WHERE d.Etat = 'Approved' 
         GROUP BY t.intitule";
$result2 = $conn->query($sql2);
$leaveTypeData = [];
while($row = $result2->fetch_assoc()) {
    $leaveTypeData[] = $row;
}

// Leaves per Month
$sql3 = "SELECT MONTH(DateDebut) as month, COUNT(*) as count 
         FROM DemandeConge 
         WHERE Etat = 'Approved' 
         GROUP BY MONTH(DateDebut)";
$result3 = $conn->query($sql3);
$leavesPerMonthData = [];
while($row = $result3->fetch_assoc()) {
    $leavesPerMonthData[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link
      rel="shortcut icon"
      href="images/logo.png"
      type="image/png"
    />

    <title>Home page</title>
    <style>
        .tile_count {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .tile_count .tile_stats_count {
            text-align: center;
            padding: 20px;
            border-radius: 5px;
            background-color: #f7f7f7;
        }
        .tile_count .count_top {
            font-size: 14px;
            color: #5a5a5a;
        }
        .tile_count .count {
            font-size: 24px;
            font-weight: bold;
            color: grey;
        }
        .left_col {
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }
        
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                                <li><a href="profileAdmin.php"><i class="fa fa-user"></i> Profile </a></li>
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
                <div class="row">
                    <div class="tile_count col-md-12 col-sm-12">
                        <div class="col-md-3 col-sm-4 tile_stats_count">
                            <span class="count_top"><i class="fa fa-users"></i> Total Employees</span>
                            <div class="count" id="total-employees" data-count="<?php echo $total_employees; ?>">0</div>
                        </div>
                        <div class="col-md-2 col-sm-5 tile_stats_count">
                            <span class="count_top"><i class="fa fa-male"></i> Male Employees</span>
                            <div class="count" id="male-employees" data-count="<?php echo $male_employees; ?>">0</div>
                        </div>
                        <div class="col-md-2 col-sm-4 tile_stats_count">
                            <span class="count_top"><i class="fa fa-female"></i> Female Employees</span>
                            <div class="count" id="female-employees" data-count="<?php echo $female_employees; ?>">0</div>
                        </div>
                        <div class="col-md-2 col-sm-4 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Married Employees</span>
                            <div class="count" id="married-employees" data-count="<?php echo $married_employees; ?>">0</div>
                        </div>
                        <div class="col-md-3 col-sm-5 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Single Employees</span>
                            <div class="count" id="single-employees" data-count="<?php echo $single_employees; ?>">0</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Leave Status <small>Overview</small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <canvas id="leaveStatusChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- FILL THIS ONE WITH A CHART PIE THAT SHOWS THE DISTIBUTION OF LEAVE STATUS -->
                    <div class="col-md-6 col-sm-12 ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Leave Status Distribution <small>Overview</small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <canvas id="leaveStatusDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Leave Type Distribution <small>Overview</small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <canvas id="leaveTypeChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Leaves Per Month <small>Overview</small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <canvas id="leavesPerMonthChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <script src="../build/js/custom.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const countElements = document.querySelectorAll('.count');
            countElements.forEach(el => {
                const countTo = el.getAttribute('data-count');
                animateValue(el, 0, countTo, 2000);
            });
        });

        function animateValue(element, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                element.textContent = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Prepare data for the leave status chart
        const leaveStatusData = {
            labels: <?php echo json_encode(array_column($leaveStatusData, 'Etat')); ?>,
            datasets: [{
                label: 'Leave Status',
                data: <?php echo json_encode(array_column($leaveStatusData, 'count')); ?>,
                backgroundColor: 'rgba(55, 15, 4, 0.2)',
                borderColor: 'rgba(55, 15, 64, 1)',
                borderWidth: 1
            }]
        };

        const leaveStatusConfig = {
            type: 'line',
            data: leaveStatusData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };


        // Prepare data for the leave status Distribution chart
        const leaveStatusDData = {
            labels: <?php echo json_encode(array_column($leaveStatusDData, 'Etat')); ?>,
            datasets: [{
                label: 'Leave Status Distribution',
                data: <?php echo json_encode(array_column($leaveStatusDData, 'count')); ?>,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 16, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        };

        const leaveStatusDConfig = {
            type: 'pie',
            data: leaveStatusDData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };




        // Prepare data for the leave type chart
        const leaveTypeData = {
            labels: <?php echo json_encode(array_column($leaveTypeData, 'intitule')); ?>,
            datasets: [{
                label: 'Leave Types',
                data: <?php echo json_encode(array_column($leaveTypeData, 'count')); ?>,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',    
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        };

        const leaveTypeConfig = {
            type: 'pie',
            data: leaveTypeData,
            options: {
                responsive: true,
            }
        };

        // Prepare data for the leaves per month chart
        const leavesPerMonthData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Leaves Per Month',
                data: <?php echo json_encode(array_column($leavesPerMonthData, 'count')); ?>,
                backgroundColor: 'rgba(255, 159, 4, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        };

        const leavesPerMonthConfig = {
            type: 'bar',
            data: leavesPerMonthData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Render charts
        window.onload = () => {
            const leaveStatusCtx = document.getElementById('leaveStatusChart').getContext('2d');
            new Chart(leaveStatusCtx, leaveStatusConfig);

            const leaveStatusDistributionChartCtx = document.getElementById('leaveStatusDistributionChart').getContext('2d');
            new Chart(leaveStatusDistributionChartCtx, leaveStatusDConfig);

            const leaveTypeCtx = document.getElementById('leaveTypeChart').getContext('2d');
            new Chart(leaveTypeCtx, leaveTypeConfig);

            const leavesPerMonthCtx = document.getElementById('leavesPerMonthChart').getContext('2d');
            new Chart(leavesPerMonthCtx, leavesPerMonthConfig);
        };
    </script>
</body>
</html>
