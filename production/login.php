<?php
session_start();

// Function to log details
function log_attempt($email, $password, $ip_address, $device_info, $status) {
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $log_entry = "$date : $time : $email : $password : $ip_address : $device_info : $status\n";

    $log_file = __DIR__ . '/logs.txt';
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

// if admin already logged in, redirect to profileadmin.php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("Location: dashboard.php"); 
    exit;
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$host = 'localhost';
$dbname = 'GestionConge';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Track login attempts
if (!isset($_SESSION["attempts"])) {
    $_SESSION["attempts"] = 0;
    $_SESSION["lockout_time"] = 0;
}

// Handle login attempts and lockout
if ($_SESSION["attempts"] >= 3 && time() < $_SESSION["lockout_time"]) {
    $login_err = "Too many failed login attempts. Please try again later.";
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter your email.";
        } else {
            $email = trim($_POST["email"]);
        }

        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter your password.";
        } else {
            $password = trim($_POST["password"]);
        }

        if (empty($email_err) && empty($password_err)) {
            $sql = "SELECT adminPPR, username, password FROM admin WHERE email = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_email);
                $param_email = $email;

                if ($stmt->execute()) {
                    $stmt->store_result();

                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($adminPPR, $username, $stored_password);
                        if ($stmt->fetch()) {
                            if ($password === $stored_password) {
                                $_SESSION["loggedin"] = true;
                                $_SESSION["adminPPR"] = $adminPPR;
                                $_SESSION["username"] = $username;
                                $_SESSION["login_time"] = time();

                                $_SESSION["attempts"] = 0;

                                // Log successful login
                                $ip_address = $_SERVER['REMOTE_ADDR'];
                                $device_info = $_SERVER['HTTP_USER_AGENT'];
                                log_attempt($email, $password, $ip_address, $device_info, 'Success');
                                
                                header("location: dashboard.php");
                                exit;
                            } else {
                                $login_err = "Invalid Credentials.";
                            }
                        }
                    } else {
                        $login_err = "Invalid Credentials.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                $stmt->close();
            }

            // Increment login attempts
            $_SESSION["attempts"]++;
            if ($_SESSION["attempts"] >= 3) {
                $_SESSION["lockout_time"] = time() + 60; // Lockout for 1 minute
                $login_err = "Too many failed login attempts. Please try again later.";
            }
            
            // Log failed attempt
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $device_info = $_SERVER['HTTP_USER_AGENT'];
            log_attempt($email, $password, $ip_address, $device_info, 'Failed');
        }
    }
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
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.png" type="image/png">

    <title>Login</title>
    <style>
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150px; /* Adjust height as needed */
        }
        .logo-container img {
            height: 150px; /* Adjust height as needed */
        }
        .card {
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">
        <div class="logo-container">
            <img src="images/logo.png" alt="Logo">
        </div>
        <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h1 class="text-center mb-4">Admin</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" id="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" required />
                        <label class="form-label" for="email">Email address</label>
                        <div class="invalid-feedback"><?php echo $email_err; ?></div>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required />
                        <label class="form-label" for="password">Password</label>
                        <div class="invalid-feedback"><?php echo $password_err; ?></div>
                    </div>

                    <!-- Error message -->
                    <div class="form-group mb-4">
                        <?php if (!empty($login_err)) : ?>
                            <div class="alert alert-danger"><?php echo $login_err; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
                </form>

                <!-- Forgot password link -->
                <div class="forgot-password" style="text-align:center;">
                    <a href="forgot_password.php">Forgot Password?</a>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div style="text-align:center;">
            2024 @ Province de Guercif --<small> Developed and secured By BAAZZA SALAHEDDINE</small>
        </div>
        <div class="clearfix"></div>
    </footer>
    
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"></script>
</body>
</html>
