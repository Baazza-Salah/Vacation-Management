<?php
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

$email = "";
$email_err = $success_msg = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty($email_err)) {
        // Check if email exists
        $sql = "SELECT email FROM admin WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = $email;

            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    // Generate a unique token
                    $token = bin2hex(random_bytes(50));
                    $expires = date("U") + 3600; // Token expires in 1 hour

                    // Insert token into database
                    $sql = "INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)";
                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("sss", $param_email, $token, $expires);
                        if ($stmt->execute()) {
                            // Send email with reset link
                            $reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;
                            $subject = "Password Reset Request";
                            $message = "To reset your password, please click the link below:\n\n" . $reset_link;
                            $headers = "From: no-reply@yourdomain.com";

                            if (mail($email, $subject, $message, $headers)) {
                                $success_msg = "A password reset link has been sent to your email.";
                            } else {
                                $email_err = "Failed to send the reset email.";
                            }
                        } else {
                            $email_err = "Failed to save reset token.";
                        }
                    }
                } else {
                    $email_err = "No account found with that email.";
                }
            } else {
                $email_err = "Something went wrong. Please try again.";
            }
            $stmt->close();
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
    <title>Forgot Password</title>
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
                <h1 class="text-center mb-4">Forgot Password</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" id="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" required />
                        <label class="form-label" for="email">Email address</label>
                        <div class="invalid-feedback"><?php echo $email_err; ?></div>
                    </div>

                    <!-- Success message -->
                    <div class="form-group mb-4">
                        <?php if (!empty($success_msg)) : ?>
                            <div class="alert alert-success"><?php echo $success_msg; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap Bundle -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
