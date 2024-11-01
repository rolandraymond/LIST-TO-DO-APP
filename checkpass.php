<?php
session_start();
// Enable error reporting for debugging
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check request method and headers
// echo 'Request Method: ' . $_SERVER['REQUEST_METHOD'] . '<br>';
// echo 'Content-Type: ' . $_SERVER['CONTENT_TYPE'] . '<br>';

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'DP_USERS');

if (!$conn) {
    echo 'Connection failed: ' . mysqli_connect_error();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['User_Name'] ?? '';
    $password = $_POST['password'] ?? '';
    // echo 'Received Username: ' . $username . '<br>';
    // echo 'Received Password: ' . $password;
    $stmt = $conn->prepare('SELECT ID, password FROM dp_users where User_Name=? ');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    if ($hashed_password) {
        // echo 'Hashed password from database: ' . $hashed_password . '<br>';
        if (password_verify($password, $hashed_password)) {
            // echo 'password:' . $password;
            $_SESSION['user_id'] = $user_id;
            echo 'Login successful';
        }
    } else {
        echo 'Invalid username or password.';
    }
} else {
    echo 'No data received';
}
