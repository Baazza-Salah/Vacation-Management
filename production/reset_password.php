<?php
session_start();

// Include your database connection
$host = 'localhost';
$dbname = 'GestionConge';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$token = $_GET['token'] ?? '';
$new_password = "";
$token_err = $password_err = $success_msg = "";

// Verify the token
if ($token) {
    $sql = "SELECT email, expires FROM password_resets WHERE token = ? AND expires > ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $param_token, $param_time);
        $param_token = $token;
        $param_time = date("U");

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                // Token is valid
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty(trim($_POST["password"]))) {
                        $password_err = "Please enter a new password.";
                    } else {
                        $new_password = trim($_POST["password"]);
                    }

                    if (empty($password_err)) {
                        // Update the password
                        $sql = "UPDATE admin SET password = ? WHERE email = (SELECT email FROM password_resets WHERE token = ?)";
                        if ($stmt = $conn->prepare($sql)) {
                            $stmt->bind_param("ss", $param_password, $param_token);
                            $param_password = $new_password;
                            $param_token = $token;

                            if ($stmt->execute()) {
                                // Remove the reset token
                                $sql = "DELETE FROM password_resets WHERE token = ?";
                                if ($stmt = $conn->prepare($sql)) {
                                    $stmt->bind_param("s", $param_token);
                                    $stmt->execute();
                                    $success_msg = "Your password has been reset successfully. You can now <a href='login.php'>login</a>.";
                                } else {
                                    $password_err = "Failed to remove reset token.";
                                }
                            } else {
                                $password_err = "Failed to update password.";
                            }
                        }
                    }
                }
            } else {
                $token_err = "Invalid or expired token.";
            }
        } else {
            $token_err = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
} else {
    header("Location: forgot_password.php");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">
        <div class="card shadow-sm" style="width: 100%; max-width: 500px;">
            <div class="card-body">
                <h1 class="text-center mb-4">Reset Password</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <!-- New Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required />
                        <label class="form-label" for="password">New Password</label>
                        <div class="invalid-feedback"><?php echo $password_err; ?></div>
                    </div>

                    <!-- Error message -->
                    <div class="form-group mb-4">
                        <?php if (!empty($token_err)) : ?>
                            <div class="alert alert-danger"><?php echo $token_err; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($success_msg)) : ?>
                            <div class="alert alert-success"><?php echo $success_msg; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Reset Password</button>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap Bundle -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
