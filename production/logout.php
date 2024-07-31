<?php
// Start session
session_start();

// Function to logout details
function log_logout($username, $ip_address, $device_info) {
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $log_entry = "$date : $time : $username : LOGOUT : $ip_address : $device_info\n";

    // path to logs.txt
    $log_file = __DIR__ . '/logs.txt'; 
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}


$username = $_SESSION["username"] ?? 'Unknown User';

// Destroy the session
session_unset();
session_destroy();

// Log the logout details
$ip_address = $_SERVER['REMOTE_ADDR'];
$device_info = $_SERVER['HTTP_USER_AGENT'];
log_logout($username, $ip_address, $device_info);

// Prevent caching of the page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0"); 
header("Location: index.html");
exit;
?>
