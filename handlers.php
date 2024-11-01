<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$conn = mysqli_connect('localhost', 'root', '', 'DP_USERS');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo "POST data:<br>";
    print_r($_POST);

    $user_name = isset($_POST['User_Name']) ? trim($_POST['User_Name']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($user_name) || empty($password)) {
        die("Error: All fields are required.");
    }
    echo "User_Name: " . $user_name . "<br>";
    echo "Password: " . $password . "<br>";
    $checkUserSql = "SELECT * FROM DP_USERS WHERE User_Name = ?";
    $checkStmt = $conn->prepare($checkUserSql);
    $checkStmt->bind_param("s", $user_name);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if ($result->num_rows > 0) {
        die("Error: Username already exists.");
    }
    $checkStmt->close();

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert into database
    $sql = "INSERT INTO DP_USERS (User_Name, password) VALUES (?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ss", $user_name, $hashed_password);

    // Execute the query
    if ($stmt->execute()) {
        echo "Account created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
}
$conn->close();